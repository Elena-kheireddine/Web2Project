<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'yoga');

// Attempt to establish a connection to the MySQL server
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die("Failed to connect to the server: " . mysqli_connect_error());
}
?>