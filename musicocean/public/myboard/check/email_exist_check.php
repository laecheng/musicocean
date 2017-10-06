<?php
$stmt = $mysqli->prepare("SELECT * FROM users WHERE email= ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ( $result->num_rows > 0 ) {
    $emailErr = "user with this email address already exists";
    $error = 1;
}
