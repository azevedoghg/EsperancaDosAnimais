<?php
session_start();
require_once '../db_config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Acesso não autorizado']);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    // Pega os dados enviados como JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id']) || !isset($data['status'])) {
        throw new Exception('Dados incompletos.');
    }

    $id = $data['id'];
    $status = $data['status'];
    $allowed_statuses = ['Pendente', 'Aprovado', 'Reprovado'];

    if (!in_array($status, $allowed_statuses)) {
        throw new Exception('Status inválido.');
    }

    $sql = "UPDATE applications SET status = :status WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso.']);
    } else {
        throw new Exception('Falha ao atualizar o status.');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
