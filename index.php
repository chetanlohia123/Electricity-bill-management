<?php
session_start();
if (isset($_SESSION['admin_id']) || isset($_SESSION['cust_id'])) {
    header("Location: " . (isset($_SESSION['admin_id']) ? "admin/admin_dashboard.php" : "user/user_dashboard.php"));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Electricity Bill System</h1>
        <form action="login.php" method="POST">
            <label for="login_id">Login ID:</label>
            <input type="text" id="login_id" name="login_id" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>