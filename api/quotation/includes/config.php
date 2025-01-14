<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'portaltakaful_thirdparty');
define('DB_PASS', 'R7ADQb(kQ~[n');
define('DB_NAME', 'portaltakaful_thirdparty');
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    // Use a more silent way to log the error, if necessary
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    exit(); // Exit if connection fails
}
?>