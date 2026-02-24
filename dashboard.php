<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search != '') {
    $stmt = $conn->prepare("SELECT * FROM posts 
                            WHERE title LIKE :search 
                            OR content LIKE :search 
                            ORDER BY created_at DESC 
                            LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
} else {
    $stmt = $conn->prepare("SELECT * FROM posts 
                            ORDER BY created_at DESC 
                            LIMIT :limit OFFSET :offset");
}

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$countStmt = $conn->query("SELECT COUNT(*) FROM posts");
$totalPosts = $countStmt->fetchColumn();
$totalPages = ceil($totalPosts / $limit);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body { margin:0; font-family:Arial; background:#f4f4f4; }
.top-bar { background:#243b55; color:white; padding:15px 30px; display:flex; justify-content:space-between; }
.top-bar a { color:white; text-decoration:none; margin-left:15px; }
.container { width:800px; margin:40px auto; background:white; padding:20px; }
.post { border-bottom:1px solid #ccc; padding:10px 0; }
.pagination a { margin-right:5px; }
</style>
</head>
<body>

<div class="top-bar">
<div>
Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
(<?php echo htmlspecialchars($_SESSION['role']); ?>)
</div>
<div>
<a href="add_post.php">Add Post</a>
<a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
</div>
</div>

<div class="container">

<form method="GET">
<input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
<button type="submit">Search</button>
</form>

<hr>

<?php foreach ($posts as $post): ?>
<div class="post">
<h4><?php echo htmlspecialchars($post['title']); ?></h4>
<p><?php echo htmlspecialchars($post['content']); ?></p>
<a href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a>
<?php if ($_SESSION['role'] === 'admin'): ?>
| <a href="delete_post.php?id=<?php echo $post['id']; ?>">Delete</a>
<?php endif; ?>
</div>
<?php endforeach; ?>

<div class="pagination">
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
<a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
<?php echo $i; ?>
</a>
<?php endfor; ?>
</div>

</div>
</body>
</html>