<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "blog";
$port = 3307;   // IMPORTANT

$conn = mysqli_connect($servername, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

