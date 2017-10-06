<?php
// config to login the database for this app
define('DB_USER','root');
define('DB_PASSWORD','big12201591Apple!');
define('DB_HOST','localhost');
define('DB_NAME','db20170823');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}
