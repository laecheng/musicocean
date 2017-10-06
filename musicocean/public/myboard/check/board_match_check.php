<?php
if($_SESSION['current_board_id'] != $_board_id) {
  $_SESSION['error_message'] = "your request does not match the record";
  header("location: ./error.php");
  exit;
}
if (!preg_match('/^[0-9]*$/',$_board_id)) {
  $_SESSION['error_message'] = "Invalid request, can not delete this board";
  header('location: ./error.php');
  exit;
}
$sql = "SELECT `board_id` FROM `has_boards` WHERE `user_id` = $user_id";
$result = $mysqli->query($sql);
$boardMatch = false;
while($row = $result->fetch_assoc()) {
    $board_id = $row['board_id'];
    if($_board_id === $board_id) {
      $boardMatch = true;
    }
}
if(!$boardMatch) {
  $_SESSION['error_message'] = "your request does not match the record";
  header("location: ./error.php");
  exit;
}
?>
