<?php
$mysqli->query("UPDATE logs SET sound_access = sound_access + 1 WHERE user_id =".$_SESSION['user_id']);
?>
