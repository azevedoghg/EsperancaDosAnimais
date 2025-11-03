<?php
// Inclui a configuração do banco de dados (caminho corrigido para subir um nível)
require_once '../db_config.php';

// Inicia a sessão para verificar o login
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('HTTP/1.1 401 Unauthorized');
    exit('Acesso não autorizado.');
}

// URL para redirecionar o usuário após a ação
$redirect_url = '../../admin_animais.php';

try {
    // Valida se o método é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de requisição inválido.');
    }

    // Valida campos obrigatórios
    $required_fields = ['nome', 'especie', 'sexo', 'idade', 'porte', 'castrado', 'vacinado', 'descricao'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("O campo '$field' é obrigatório.");
        }
    }
    
    // Valida e processa o upload da foto
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('O envio da foto é obrigatório.');
    }

    $foto = $_FILES['foto'];
    $upload_dir = 'uploads/'; // Salva na pasta 'api/animais/uploads/'
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($foto['type'], $allowed_types)) {
        throw new Exception('Formato de imagem inválido. Use JPG, PNG ou GIF.');
    }

    $file_extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $unique_filename = uniqid('animal_', true) . '.' . $file_extension;
    $upload_path = $upload_dir . $unique_filename;

    if (!move_uploaded_file($foto['tmp_name'], $upload_path)) {
        throw new Exception('Falha ao salvar a imagem no servidor.');
    }

    // Caminho da foto que será salvo no banco de dados (relativo à raiz do projeto)
    $db_foto_path = 'api/animais/' . $upload_path;

    // Prepara e executa a query SQL para inserir o animal
    $sql = "INSERT INTO animals (nome, especie, sexo, idade, porte, castrado, vacinado, descricao, foto_url, disponivel) 
            VALUES (:nome, :especie, :sexo, :idade, :porte, :castrado, :vacinado, :descricao, :foto_url, 1)";
    $stmt = $conn->prepare($sql);

    // Binds
    $stmt->bindParam(':nome', $_POST['nome']);
    $stmt->bindParam(':especie', $_POST['especie']);
    $stmt->bindParam(':sexo', $_POST['sexo']);
    $stmt->bindParam(':idade', $_POST['idade']);
    $stmt->bindParam(':porte', $_POST['porte']);
    $stmt->bindParam(':castrado', $_POST['castrado'], PDO::PARAM_INT);
    $stmt->bindParam(':vacinado', $_POST['vacinado'], PDO::PARAM_INT);
    $stmt->bindParam(':descricao', $_POST['descricao']);
    $stmt->bindParam(':foto_url', $db_foto_path);

    if ($stmt->execute()) {
        // Redireciona com mensagem de sucesso
        header('Location: ' . $redirect_url . '?status=success');
        exit();
    } else {
        throw new Exception('Erro do banco de dados ao inserir o animal.');
    }

} catch (Exception $e) {
    // Redireciona com mensagem de erro
    $error_message = urlencode($e->getMessage());
    header('Location: ' . $redirect_url . '?status=error&message=' . $error_message);
    exit();
}
