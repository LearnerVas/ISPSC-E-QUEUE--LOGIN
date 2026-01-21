<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendOTP($to, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hezelijahpublico@gmail.com';
        $mail->Password = 'yxyuujromchysmiu ';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('YOUR_GMAIL@gmail.com', 'ISPSC Queue');
        $mail->addAddress($to);

        $mail->Subject = 'ISPSC OTP Verification';
        $mail->Body = "Your OTP is: $otp\n\nDo not share this code.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
