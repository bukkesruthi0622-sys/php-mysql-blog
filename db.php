<?php
$host = "localhost";
$dbname = "blog";
$username = "root";
$password = "";

try {
    $conn = new PDO(
        "mysql:host=$host;port=3307;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed");
}
?>