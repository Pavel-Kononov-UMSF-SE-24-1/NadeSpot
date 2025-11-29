<?php
header('Content-Type: application/json');
require 'db.php';

// Получаем данные
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No ID provided']);
    exit;
}

try {
    // Удаляем видео
    $stmt = $pdo->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->execute([$data['id']]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Video not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>