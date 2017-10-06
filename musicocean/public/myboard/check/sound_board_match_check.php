<?php
/* sound_id and board_id must be a number!! */
if (!preg_match('/^[0-9]*$/',$_sound_id)) {
  $_SESSION['error_message'] = "sound id is not a number";
  header('location: error.php');
  exit;
}
if (!preg_match('/^[0-9]*$/',$_board_id)) {
  $_SESSION['error_message'] = "board id is not a number";
  header('location: error.php');
  exit;
}
/* Check if this sound belong to this user's !!!!!! */
$sql = "SELECT `board_id` FROM `has_boards` WHERE `user_id` = $user_id";
$result1 = $mysqli->query($sql);
$boardMatch = $soundMatch = false;
while($row1 = $result1->fetch_assoc()) {
    $board_id = $row1['board_id'];
    if($board_id === $_board_id) {
      $boardMatch = true;
    }
    $sql = "SELECT * FROM `has_sounds` WHERE `board_id` = $board_id";
    $result2 = $mysqli->query($sql);
    while($row2 = $result2->fetch_array()) {
        $sound_id = $row2[1];
        // if any id matchs
        if($_sound_id === $sound_id) {
          $soundMatch = true;
        }
    }
}
if(!($boardMatch && $soundMatch)) {
  $_SESSION['error_message'] = "your request does not match the record";
  header("location: ./error.php");
  exit;
}
?>
