<?php
include 'db.php';

/* STEP 2.1: Number of posts per page */
$limit = 3;

/* STEP 2.2: Get current page number */
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

/* STEP 2.3: Fetch paginated posts */
$stmt = $conn->prepare(
    "SELECT * FROM posts
     ORDER BY created_at DESC
     LIMIT :start, :limit"
);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
<a href="add_post.php">➕ Add New Post</a>
<hr>
<!-- STEP 2.4: Search Form -->
<form method="GET" action="search.php">
    <input
        type="text"
        name="keyword"
        placeholder="Search posts by title or content"
        required
    >
    <button type="submit">Search</button>
</form>

<hr>

<!-- STEP 2.5: Display Posts -->
<?php
foreach ($posts as $post) {
    echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
    echo "<p>" . htmlspecialchars($post['content']) . "</p>";
    echo "<hr>";
}
?>

<!-- STEP 2.6: Pagination Links -->
<?php
$totalStmt = $conn->prepare("SELECT COUNT(*) FROM posts");
$totalStmt->execute();
$totalPosts = $totalStmt->fetchColumn();
$totalPages = ceil($totalPosts / $limit);
?>

<div>
<?php
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> ";
    } else {
        echo "<a href='index.php?page=$i'>$i</a> ";
    }
}
?>
</div>

</body>
</html>