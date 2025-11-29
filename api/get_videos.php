<?php
header('Content-Type: application/json');
require 'db.php';

try {
    // Получаем видео, сортируем по ID (новые в конце, JS перевернет)
    $stmt = $pdo->query("SELECT * FROM videos ORDER BY id DESC");
    $videos = $stmt->fetchAll();
    echo json_encode($videos);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>