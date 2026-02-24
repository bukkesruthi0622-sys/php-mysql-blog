<?php
require 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) 
                            VALUES (:username, :password, :role)");

    $stmt->execute([
        ':username' => $username,
        ':password' => $password,
        ':role' => $role
    ]);

    $message = "Registration successful!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>
<body>

<h2>Register</h2>

<?php if ($message) echo "<p>$message</p>"; ?>

<form method="POST">
<input type="text" name="username" placeholder="Username" required><br>
<input type="password" name="password" placeholder="Password" required><br>

<select name="role">
<option value="editor">Editor</option>
<option value="admin">Admin</option>
</select><br><br>

<button type="submit">Register</button>
</form>

<a href="login.php">Back to Login</a>

</body>
</html>