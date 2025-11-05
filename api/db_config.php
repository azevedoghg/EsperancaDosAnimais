<?php
// Define o cabeçalho para retornar JSON e permitir requisições de qualquer origem (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Configurações do banco de dados
$host = 'localhost'; // Geralmente 'localhost' no XAMPP
$db_name = 'adocao_db';
$username = 'root'; // Usuário padrão do XAMPP
$password = ''; // Senha padrão do XAMPP é vazia
$conn = null;

try {
    // Cria a conexão com o banco de dados usando PDO
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    // Define o modo de erro do PDO para exceção, para podermos capturar erros
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Garante que a comunicação use o charset utf8mb4
    $conn->exec("set names utf8mb4");
} catch(PDOException $exception) {
    // Se a conexão falhar, exibe uma mensagem de erro em JSON e encerra o script
    http_response_code(500); // Erro interno do servidor
    echo json_encode(array("error" => "Erro de conexão: " . $exception->getMessage()));
    exit(); // Encerra a execução para evitar outros erros
}
?>

