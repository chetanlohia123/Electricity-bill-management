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
    <title>Login - Electricity Bill System</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .success { color: green; text-align: center; } 
        .error { color: red; text-align: center; }
        input, button { width: 100%; padding: 10px; margin: 5px 0; }
        button { background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if ($success_message): ?><p class="success"><?= $success_message ?></p><?php endif; ?>
        <?php if ($error_message): ?><p class="error"><?= $error_message ?></p><?php endif; ?>
        <form action="login.php" method="POST">
            <label>Email/Login ID:</label>
            <input type="text" name="login_id" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>Not registered? <a href="register.php">Sign Up</a></p>
    </div>
</body>
</html>