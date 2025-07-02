<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ia7672848@gmail.com';               // Your Gmail
    $mail->Password   = 'njaq lurn rtxe znvx';               // App Password (not Gmail login)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('ia7672848@gmail.com', 'Lost and Found');
    $mail->addAddress('ibrarkundi9@gmail.com', 'User');      // Recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = '🎯 Match Found: Lost and Found Item';
    $mail->Body    = '<p>Hello! A match has been found for your lost item. Please check your account for more details.</p>';
    $mail->AltBody = 'Hello! A match has been found for your lost item. Please check your account for more details.';

    $mail->send();
    echo "✅ Email sent successfully.";
} catch (Exception $e) {
    echo "❌ Email sending failed. Error: {$mail->ErrorInfo}";
}
?>
