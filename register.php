<?php
include "db.php";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) 
              VALUES ('$username', '$hashed_password')";

    mysqli_query($conn, $query);

    echo "Registration successful. <a href='login.php'>Login</a>";
}
?>

<h2>User Registration</h2>

<form method="post">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="register">Register</button>
</form>