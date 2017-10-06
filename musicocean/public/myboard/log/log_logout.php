<?php
$mysqli->query("UPDATE logs SET logouts = logouts + 1 WHERE user_id =".$_SESSION['user_id']);
?>
