<?php
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

$type = $data['type'];
$gmail = $data['gmail'];
$id = $data['id'] ?? null;
$student_id = strtoupper(trim($_POST['student_id'] ?? ''));


if ($type === 'old') {
    $stmt = $db->prepare(
        'SELECT * FROM students WHERE gmail = :gmail AND student_id = :id'
    );
    $stmt->bindValue(':gmail', $gmail);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute()->fetchArray();

    if (!$result) {
        http_response_code(401);
        echo json_encode(['error' => 'Student not found']);
        exit;
    }
}

session_start();
$_SESSION['pending_gmail'] = $gmail;

echo json_encode([
    'success' => true,
    
  ]);
  