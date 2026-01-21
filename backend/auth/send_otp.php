<?php
session_start();
require_once '../config/mail.php';

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';

if (!$email) {
  http_response_code(400);
  echo json_encode(['error' => 'Email required']);
  exit;
}

$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;

if (sendOTP($email, $otp)) {
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to send OTP']);
}
