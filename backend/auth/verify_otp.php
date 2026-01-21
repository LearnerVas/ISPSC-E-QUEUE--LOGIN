<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if ($data['otp'] == $_SESSION['otp']) {
    $_SESSION['authenticated'] = true;
    echo json_encode(['success' => true]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid OTP']);
}
