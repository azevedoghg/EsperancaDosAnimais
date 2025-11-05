<?php
require_once '../db_config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de requisição inválido.');
    }

    $required_fields = ['nome', 'nascimento', 'instagram', 'email', 'telefone', 'endereco', 'tipo_moradia', 'motivo', 'concorda_termos', 'animal_desejado'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("O campo '$field' é obrigatório.");
        }
    }

    // Busca o ID do animal pelo nome
    $stmt_animal = $conn->prepare("SELECT id FROM animals WHERE nome = :nome_animal AND disponivel = 1");
    $stmt_animal->bindParam(':nome_animal', $_POST['animal_desejado']);
    $stmt_animal->execute();
    $animal = $stmt_animal->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        throw new Exception('Animal não encontrado ou não está mais disponível para adoção.');
    }
    $animal_id = $animal['id'];

    $sql = "INSERT INTO applications (animal_id, nome_completo, data_nascimento, instagram, email, telefone, endereco, tipo_moradia, motivo, outros_animais, concorda_termos) 
            VALUES (:animal_id, :nome, :nascimento, :instagram, :email, :telefone, :endereco, :tipo_moradia, :motivo, :outros_animais, :concorda_termos)";
    
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':animal_id', $animal_id, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $_POST['nome']);
    $stmt->bindParam(':nascimento', $_POST['nascimento']);
    $stmt->bindParam(':instagram', $_POST['instagram']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':telefone', $_POST['telefone']);
    $stmt->bindParam(':endereco', $_POST['endereco']);
    $stmt->bindParam(':tipo_moradia', $_POST['tipo_moradia']);
    $stmt->bindParam(':motivo', $_POST['motivo']);
    $stmt->bindParam(':outros_animais', $_POST['outros_animais']);
    $stmt->bindParam(':concorda_termos', $_POST['concorda_termos'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cadastro enviado com sucesso!']);
    } else {
        throw new Exception('Erro ao salvar o cadastro no banco de dados.');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
