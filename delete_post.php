<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM posts WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: dashboard.php");
exit();
?>