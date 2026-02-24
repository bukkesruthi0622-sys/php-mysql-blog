<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: linear-gradient(135deg, #141e30, #243b55);
            color: white;
            text-align: center;
        }

        .container {
            margin-top: 180px;
        }

        .welcome {
            font-size: 32px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 10px 30px;
            background: white;
            color: #243b55;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['username'])): ?>

<div class="container">
    <div class="welcome">Welcome 😊</div>
    <a href="login.php" class="btn">Login</a>
</div>

<?php else: ?>
<?php header("Location: dashboard.php"); exit(); ?>
<?php endif; ?>

</body>
</html>