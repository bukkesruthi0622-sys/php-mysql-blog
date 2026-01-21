<?php
include 'db.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
// 🔹 EMPTY CHECK HERE
if ($keyword === '') {
    echo "<p>Please enter a search keyword.</p>";
    exit;
}
$stmt = $conn->prepare(
    "SELECT * FROM posts
     WHERE title LIKE ? OR content LIKE ?
     ORDER BY created_at DESC"
);

$searchTerm = "%" . $keyword . "%";
$stmt->execute([$searchTerm, $searchTerm]);
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>

<h2>Search Results</h2>

<?php
if ($results) {
    foreach ($results as $post) {
        echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($post['content']) . "</p>";
        echo "<hr>";
    }
} else {
    echo "<p>No results found.</p>";
}
?>

<a href="index.php">⬅ Back to Home</a>

</body>
</html>