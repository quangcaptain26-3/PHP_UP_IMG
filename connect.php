<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "up_img";
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>