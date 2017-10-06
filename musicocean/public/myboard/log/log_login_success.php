<?php
$mysqli->query("UPDATE logs SET board_access = board_access + 1 WHERE user_id =".$_SESSION['user_id']);
$mysqli->query("UPDATE logs SET login_attempts = login_attempts + 1 WHERE user_id =".$_SESSION['user_id']);
$mysqli->query("UPDATE logs SET login_success = login_success + 1 WHERE user_id =".$_SESSION['user_id']);
?>
