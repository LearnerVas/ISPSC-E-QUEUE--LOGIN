<?php
// backend/crud/students.php
require_once '../config/db.php';

// Allow cross-origin for frontend testing
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch($action) {
    case 'create':
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (
            empty($data['student_id']) ||
            empty($data['gmail']) ||
            empty($data['status'])
        ) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'All fields are required'
            ]);
            exit;
        }
    
        $stmt = $db->prepare(
            "INSERT INTO students (student_id, gmail, status)
             VALUES (:student_id, :gmail, :status)"
        );
    
        $stmt->bindValue(':student_id', strtoupper(trim($data['student_id'])));
        $stmt->bindValue(':gmail', strtolower(trim($data['gmail'])));
        $stmt->bindValue(':status', $data['status']);
    
        $result = @$stmt->execute();
    
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(409);
            echo json_encode([
                'success' => false,
                'error' => 'Student ID or Gmail already exists'
            ]);
        }
        break;
    

    case 'read':
        $res = $db->query("SELECT * FROM students");
        $students = [];
        while($row = $res->fetchArray(SQLITE3_ASSOC)){
            $students[] = $row;
        }
        echo json_encode($students);
        break;

    case 'update':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $student_id = $data['student_id'];
        $gmail = $data['gmail'];
        $status = $data['status'];

        $stmt = $db->prepare("UPDATE students SET student_id=:student_id, gmail=:gmail, status=:status WHERE id=:id");
        $stmt->bindValue(':student_id', $student_id);
        $stmt->bindValue(':gmail', $gmail);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id);

        if($stmt->execute()){
            echo json_encode(['success'=>true]);
        } else {
            echo json_encode(['success'=>false,'error'=>'Failed to update']);
        }
        break;

    case 'delete':
        $id = $_GET['id'];
        $stmt = $db->prepare("DELETE FROM students WHERE id=:id");
        $stmt->bindValue(':id', $id);

        if($stmt->execute()){
            echo json_encode(['success'=>true]);
        } else {
            echo json_encode(['success'=>false,'error'=>'Failed to delete']);
        }
        break;

    default:
        echo json_encode(['error'=>'Invalid action']);
}
