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
<?php
include "db.php";

$errors = [];

if (isset($_POST['submit'])) {

    // 🔹 EMPTY CHECKS HERE
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title === '') {
        $errors[] = "Title is required";
    }

    if ($content === '') {
        $errors[] = "Content is required";
    }

    if (strlen($title) < 3) {
        $errors[] = "Title must be at least 3 characters";
    }

    // 🔹 Only insert if NO errors
    if (empty($errors)) {
        $stmt = $conn->prepare(
            "INSERT INTO posts (title, content) VALUES (?, ?)"
        );
        $stmt->execute([$title, $content]);

        header("Location: index.php");
        exit;
    }
}
?>
<?php
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
</head>
<body>

<h2>Add New Post</h2>

<form method="POST">
    <label>Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>Content</label><br>
    <textarea name="content" rows="5" required></textarea><br><br>

    <button type="submit" name="submit">Add Post</button>
</form>

<a href="index.php">⬅ Back</a>

</body>
</html>