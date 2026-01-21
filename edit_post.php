<?php
include "db.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM posts WHERE id = $id");
$post = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $update = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    mysqli_query($conn, $update);

    header("Location: index.php");
}
?>

<h2>Edit Post</h2>

<form method="post">
    Title:<br>
    <input type="text" name="title" value="<?php echo $post['title']; ?>" required><br><br>

    Content:<br>
    <textarea name="content" required><?php echo $post['content']; ?></textarea><br><br>

    <button type="submit" name="update">Update Post</button>
</form>
