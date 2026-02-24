<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("INSERT INTO posts (title, content, created_at) 
                            VALUES (:title, :content, NOW())");

    $stmt->execute([
        ':title' => $_POST['title'],
        ':content' => $_POST['content']
    ]);

    header("Location: dashboard.php");
    exit();
}
?>

<h2>Add Post</h2>

<form method="POST">
<input type="text" name="title" placeholder="Title" required><br>
<textarea name="content" required></textarea><br>
<button type="submit">Add</button>
</form>