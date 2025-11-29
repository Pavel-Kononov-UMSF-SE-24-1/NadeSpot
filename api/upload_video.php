<?php
header('Content-Type: application/json');
require 'db.php';

// Получаем JSON от JS
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'No data']);
    exit;
}

// В реальном проекте тут нужна проверка авторизации (сессии)!
// Для простоты пока сохраняем так.

try {
    $sql = "INSERT INTO videos (title, category, map, position, side, difficulty, description, src, type, author_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([
        $data['title'],
        $data['category'],
        $data['map'],
        $data['position'],
        $data['side'],
        $data['difficulty'],
        $data['description'],
        $data['src'],
        $data['type'],
        1 // Временно ставим ID 1, пока не настроили авторизацию
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>