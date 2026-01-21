<?php
session_start();

$otp = $_POST['otp'] ?? '';

if ($otp == ($_SESSION['otp'] ?? null)) {
  $_SESSION['logged_in'] = true;
  echo json_encode(['success' => true]);
} else {
  http_response_code(401);
  echo json_encode(['error' => 'Invalid OTP']);
}
