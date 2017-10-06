<?php
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
  //Server settings
  //$mail->SMTPDebug = 2;
  $mail->isSMTP();
  $mail->Mailer = 'smtp';
  $mail->SMTPAuth = true;
  $mail->Host = 'smtp.gmail.com';
  $mail->Username = 'laecheng@gmail.com';
  $mail->Password = 'big12201591Apple!';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  //Recipients
  $mail->setFrom('laecheng@gmail.com', 'chaoran');
  $mail->addAddress($to, $first_name);

  //Content
  $mail->Subject = $subject;
  $mail->Body = $message_body;
  $mail->AltBody = $message_body;

  $mail->send();
} catch (Exception $e) {
  echo 'Mailer Error: ' . $mail->ErrorInfo;
}
