<?php
// Configurações de conexão com o banco de dados
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = 'localhost';
$db_name = 'adocao_db';
$username = 'root';
$password = ''; // Senha padrão do XAMPP é vazia

try {
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8mb4");
} catch(PDOException $exception) {
    http_response_code(500);
    echo json_encode(array("error" => "Erro de conexão: " . $exception->getMessage()));
    exit();
}
?>