<?php
// page to handle all kinds of errors
session_start();

if(isset($_SESSION['error_message'])) {
  echo $_SESSION['error_message'];
} else  {
  header('location: ./soundboard.php');
}
