<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute([':id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $update = $conn->prepare("UPDATE posts SET title=:title, content=:content WHERE id=:id");
    $update->execute([
        ':title' => $_POST['title'],
        ':content' => $_POST['content'],
        ':id' => $id
    ]);

    header("Location: dashboard.php");
    exit();
}
?>

<h2>Edit Post</h2>

<form method="POST">
<input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>"><br>
<textarea name="content"><?php echo htmlspecialchars($post['content']); ?></textarea><br>
<button type="submit">Update</button>
</form>