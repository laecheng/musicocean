<?php
/* The Reset password Business logic after user
   clicked the reset link
 */
session_start();
require 'db.php';

// Make sure email and hash variables aren't empty
if(isset($_GET['email']) && isset($_SESSION['reset_email']) && $_GET['email'] === $_SESSION['reset_email']
&& isset($_GET['hash']) && isset($_SESSION['reset_hash']) && $_GET['hash'] === $_SESSION['reset_hash']) {

    $email = $_GET['email'];
    $hash = $_GET['hash'];
    $email = trim($email);
    $email = stripslashes($email);
    $email = htmlspecialchars($email);
    $hash = trim($hash);
    $hash = stripslashes($hash);
    $hash = htmlspecialchars($hash);

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param('ss', $email, $hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ( $result->num_rows === 0 ) {
        // the url is invalid
        $error_message = "auth fails, can not find your account.";
        include './views/password_reset_error.tpl';
    } else {
        // auth success, render the reset password page for user
        $newpasswordError = $confirmpasswordError = "";
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_hash'] = $hash;
        include './views/password_reset.tpl';
    }
} else {
    $error_message = "the reset link is not valid or link has expired.";
    include './views/password_reset_error.tpl';
}
