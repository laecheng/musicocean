<?php
session_start();
require '../db.php';
// check if user is logged in or not valid user
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == 0) {
  // if not, redirect to login page
  header('location: ./index.php');
  exit;
} else { // collect the info of this user
  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_board_id = $_POST['board_id'];
    $user_id = $_SESSION['user_id'];

    // easy access for admin
    if($_SESSION['isadmin']) {
      $_SESSION['current_board_id'] = $_board_id;
      echo  $_SESSION['current_board_id'];
      exit;
    }

    /* board_id must be a number!! */
    if (!preg_match('/^[0-9]*$/',$_board_id)) {
      echo "ERROR";
      exit;
    }
    /* check if user own this board */
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
      echo "ERROR";
      exit;
    } else {
      $_SESSION['current_board_id'] = $_board_id;
      echo  $_SESSION['current_board_id'];
    }
  }
}
?>
