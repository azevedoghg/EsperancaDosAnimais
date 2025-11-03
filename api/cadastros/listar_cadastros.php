<?php
// Define o cabeçalho para retornar JSON
header('Content-Type: application/json');

// Inclui a configuração do banco de dados usando um caminho absoluto e robusto
require_once dirname(__DIR__) . '/db_config.php';

try {
    // Prepara e executa a query para buscar todos os animais disponíveis
    $stmt = $conn->prepare("SELECT * FROM listar_cadastros WHERE disponivel = 1 ORDER BY created_at DESC");
    $stmt->execute();

    // Busca todos os resultados como um array associativo
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os dados em formato JSON
    echo json_encode($animals);

} catch (PDOException $e) {
    // Em caso de erro, retorna uma mensagem de erro em JSON
    http_response_code(500); // Erro interno do servidor
    echo json_encode(['error' => 'Não foi possível buscar os animais: ' . $e->getMessage()]);
}

