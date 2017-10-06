<?php
$mysqli->query("UPDATE logs SET login_fails = login_fails + 1 WHERE user_id =".$_SESSION['user_id']);
$mysqli->query("UPDATE logs SET login_attempts = login_attempts + 1 WHERE user_id =".$_SESSION['user_id']);
?>
