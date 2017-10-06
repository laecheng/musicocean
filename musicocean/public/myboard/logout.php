<?php
/* Log out process, unsets and destroys session variables */
session_start();
require './check/sessioncheck.php';
require './db.php';
require './log/log_logout.php';
session_unset();
session_destroy();
header('location: ./soundboard.php');
