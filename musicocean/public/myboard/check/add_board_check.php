<?php
$error = false;
if(empty($board_name)) {
  $err_message = "name is empty";
  $error = true;
} else if (strlen($board_name) > 30) {
  $err_message = "board name should less than 30 character";
  $error = true;
} else { // sanitize data
  $sound_name = clean_input($board_name);
}
// If any error dected, goes to error page
if($error) {
  $_SESSION['error_message'] = $err_message;
  header('location: ./error.php');
  exit;
}
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
