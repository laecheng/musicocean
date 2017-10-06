<?php
/* Verifies registered user email, the link to this page
   is included in the register.php email message
*/
require 'db.php';
session_start();

// Make sure email and hash variables aren't empty
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND active = 0");
    $stmt->bind_param('ss', $email, $hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ( $result->num_rows == 1 )
    {
        $_SESSION['active'] = 1;
        $mysqli->query("UPDATE users SET active='1' WHERE email='$email' ");
        include './views/activesuccess.tpl';
    }
    else {
        include './views/activefails.tpl';
    }
} else {
    $_SESSION['error_message'] = "The address you are requesting is not valid";
    header('location: ./error.php');
}
