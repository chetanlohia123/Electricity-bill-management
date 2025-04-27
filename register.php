<?php
session_start();
include('includes/db_connection.php');
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Electricity Bill System</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if ($error_message): ?><p class="error"><?= $error_message ?></p><?php endif; ?>
        <form action="register_logic.php" method="POST">
            <label for="name">Name:</label><input type="text" id="name" name="name" required>
            <label for="email">Email:</label><input type="email" id="email" name="email" required>
            <label for="password">Password:</label><input type="password" id="password" name="password" required>
            <label for="address">Address:</label><input type="text" id="address" name="address" required>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <p>Have an account? <a href="index.php">Login</a></p>
    </div>
</body>
</html>
