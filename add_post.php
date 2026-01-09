<?php
include "db.php";

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    mysqli_query($conn, $sql);
}
?>

<h2>Add New Post</h2>

<form method="post">
    Title:<br>
    <input type="text" name="title" required><br><br>

    Content:<br>
    <textarea name="content" required></textarea><br><br>

    <button type="submit" name="submit">Add Post</button>
</form>
