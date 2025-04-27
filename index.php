<?php
session_start();
if (isset($_SESSION['admin_id']) || isset($_SESSION['cust_id'])) {
    header("Location: " . (isset($_SESSION['admin_id']) ? "admin/admin_dashboard.php" : "user/user_dashboard.php"));
    exit();
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>.success { color: green; } .error { color: red; }</style>
</head>
<body>
    <div class="container">
        <h1>Electricity Bill System</h1>
        <?php if ($success_message): ?>
            <div class="success"><?= $success_message ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="error"><?= $error_message ?></div>
        <?php endif; ?>
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