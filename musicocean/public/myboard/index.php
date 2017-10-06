<?php
session_start();
/* connect to database */
require 'db.php';

$first_name = $last_name = $email = $password = "";
$first_nameErr = $last_nameErr = $emailErr = $passwordErr = "";
$error = false;

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sign'])) {
  if($_GET['sign'] == "signup") {
    require './views/signup.tpl';
  } else if ($_GET['sign'] == "signin"){
    require './views/signin.tpl';
  }
  exit;
}
/* if user require the register page, send register page back no validation needed*/
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['user_submit'] == 'signup') {
  require './views/signup.tpl';
  exit;
}

/* Validate and Sanitize data for register and signin */
require './check/sign_in_up_check.php';

/* if no errors, then goes to the login and register process */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$error) {

    /* Log in process goes here */
    if($_POST['user_submit'] == 'signin') {
        require 'login.php';
        exit();
    }
    /* Register process goes here */
    else if ($_POST['user_submit'] == 'register') {

        require './check/email_exist_check.php';
        if($error == 1) {
          include './views/signup.tpl';
          exit();
        }

        require 'register.php';
    }
}
// render the sign up/ sign in page using template
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['user_submit'] == 'register') {
    require './views/signup.tpl';
} else {
    require './views/signin.tpl';
}
