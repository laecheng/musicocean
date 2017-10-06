<?php
/* Check if is a valid user before checking the request type */
if($_SERVER['REQUEST_METHOD'] != 'POST') {
  header('location: ./editboard.php');
  exit;
}
?>
