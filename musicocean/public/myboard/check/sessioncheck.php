<?php
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == 0) {
  // if not, redirect to login page
  header('location: ./index.php');
  exit;
} else { // collect the info of this user
  $first_name = $_SESSION['first_name'];
  $last_name = $_SESSION['last_name'];
  $email = $_SESSION['email'];
  $user_id = $_SESSION['user_id'];
  $board_id = $_SESSION['current_board_id'];
}
?>
