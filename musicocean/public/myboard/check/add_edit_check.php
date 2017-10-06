<?php
$error = false;
if(empty($_sound_name)) {
  $err_message = "name is empty";
  $error = true;
} else if (strlen($_sound_name) > 30) {
  $err_message = "name should less than 30 character";
  $error = true;
} else { // sanitize data
  $_sound_name = clean_input($_sound_name);
}
// If any error dected, goes to error page
if($error) {
  $_SESSION['error_message'] = $err_message;
  header('location: error.php');
  exit;
}

function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
