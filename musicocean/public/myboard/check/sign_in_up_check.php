<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  // validate data
  if($_POST['user_submit'] == 'register') {
    if(empty($_POST['lastname']) ) {
      $last_nameErr = "last name is required";
      $error = true;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['lastname'])) {
      $last_nameErr = "Only letters and white space allowed";
      $error = true;
    } else if (strlen($_POST['lastname'] > 20)) {
      $last_nameErr = "last name execced max length";
      $error = true;
    } else { // sanitize data
      $last_name = clean_input($_POST['lastname']);
    }

    if(empty($_POST['firstname'])) {
      $first_nameErr = "fisrst name is required";
      $error = true;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['firstname'])) {
      $first_nameErr = "Only letters and white space allowed";
      $error = true;
    } else if (strlen($_POST['firstname'] > 20)) {
      $first_nameErr = "first name execced max length";
      $error = true;
    } else { // sanitize data
      $first_name = clean_input($_POST['firstname']);
    }
  }

  if(empty($_POST['email'])) {
    $emailErr = "Email is required";
    $error = true;
  } else if (strlen($_POST['email']) > 40) {
    $emailErr = "Email execced max length";
    $error = true;
  } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
    $error = true;
  } else { // sanitize data
    $email = clean_input($_POST['email']);
  }

  if(empty($_POST['password'])) {
    $passwordErr = "password is required";
    $error = true;
  } else if (!preg_match('/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $_POST['password'])) {
    $passwordErr = "password must be at least 8 characters with upper, lower letter, digit";
    $error = true;
  } else { // sanitize data
    $password = clean_input($_POST['password']);
  }
}
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
