<?php
$mysqli->query("UPDATE logs SET board_access = board_access + 1 WHERE user_id =".$_SESSION['user_id']);
?>
