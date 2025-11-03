<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Credenciais fixas (para este projeto de exemplo)
// Num projeto real, isto viria de um banco de dados com senhas encriptadas.
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método não permitido.']);
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
    // Se as credenciais estiverem corretas, define a variável de sessão
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    echo json_encode(['success' => true]);
} else {
    // Se as credenciais estiverem erradas, envia uma mensagem de erro
    echo json_encode(['error' => 'Utilizador ou senha inválidos.']);
}
?>
