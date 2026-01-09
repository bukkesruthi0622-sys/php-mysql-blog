<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db.php";
$result = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC");
?>

<p>
Welcome, <strong><?php echo $_SESSION['username']; ?></strong> |
<a href="logout.php">Logout</a>
</p>

<h2>All Blog Posts</h2>
<a href="add_post.php">➕ Add New Post</a>
<hr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['content']; ?></p>
    <small><?php echo $row['created_at']; ?></small><br>

    <a href="edit_post.php?id=<?php echo $row['id']; ?>">✏ Edit</a> |
    <a href="delete_post.php?id=<?php echo $row['id']; ?>"
       onclick="return confirm('Are you sure you want to delete this post?');">
       ❌ Delete
    </a>
    <hr>
<?php } ?>