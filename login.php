<?php
session_start();
require 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "All fields are required!";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body { font-family: Arial; background:#f4f4f4; }
.container { width:350px; margin:100px auto; background:white; padding:20px; box-shadow:0 0 10px #ccc; }
input { width:100%; padding:8px; margin-bottom:10px; }
button { padding:8px 15px; }
.error { color:red; }
.password-container { position:relative; }
.toggle { position:absolute; right:10px; top:8px; cursor:pointer; }
</style>
</head>
<body>

<div class="container">
<h2>Login</h2>

<?php if ($error): ?>
<p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
<label>Username</label>
<input type="text" name="username" required>

<label>Password</label>
<div class="password-container">
<input type="password" id="password" name="password" required>
<span class="toggle" onclick="togglePassword()">👁</span>
</div>

<button type="submit">Login</button>
</form>

<br>
<a href="register.php">Register</a>
</div>

<script>
function togglePassword() {
    var x = document.getElementById("password");
    x.type = (x.type === "password") ? "text" : "password";
}
</script>

</body>
</html>