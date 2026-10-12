<?php
session_start();
include "db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        if ($password === $admin["password"]) {
            $_SESSION["admin"] = $admin["username"];
            header("Location: dashboard.php");
            exit();
        }
    }
    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">
<div class="login-container">
    <div class="login-icon">🔐</div>
    <h1>Admin Login</h1>
    <p>Sign in to manage college notices.</p>
    <?php if ($error): ?><div class="error-message"><?php echo $error; ?></div><?php endif; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username" required>
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>
        <button type="submit" class="login-btn">Login →</button>
    </form>
    <div class="login-info">Demo Login<br>Username: <b>admin</b><br>Password: <b>admin123</b></div>
    <a href="index.php">← Back to Home</a>
</div>
</body>
</html>