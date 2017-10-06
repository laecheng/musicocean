<?php
session_start();
/* connect to database */
require 'db.php';

$error = $emailErr = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {

    $email = $_POST['email'];
    $email = trim($email);
    $email = stripslashes($email);
    $email = htmlspecialchars($email);
    $error = false;

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email= ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ( $result->num_rows == 0 ) {
        $emailErr = "can not find user with this email";
        $error = true;
    }

    if($error) {

      include './views/forgetpassword.tpl';

    } else {

      // sent password reset link to user email
      $user = $result->fetch_assoc();
      $hash = $user['password'];
      $first_name = $user['first_name'];
      $_SESSION['reset_email'] = $email;
      $_SESSION['reset_hash'] = $hash;

      $to = $email;
      $subject = 'Password Reset ( www.qooqles.com)';
      $message_body = '
      Hello '.$first_name.',<br>

      You are trying to reset your password!<br>

      Please copy and paste this link to your browser to forward to next step:<br>

      http://www.qooqles.com/myboard/resetpassword.php?email='.$email.'&hash='.$hash.'<br>';

      require './sendmail.php';
      include './views/email_sent.tpl';

    }
    
} else {

    include './views/forgetpassword.tpl';

}
