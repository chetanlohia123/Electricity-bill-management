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
    <style>
        .container { max-width: 400pagpx; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .error { color: red; text-align: center; }
        input, select, button { width: 100%; padding: 10px; margin: 5px 0; }
        button { background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if ($error_message): ?><p class="error"><?= $error_message ?></p><?php endif; ?>
        <form action="register_logic.php" method="POST">
            <label>Name:</label><input type="text" name="name" required>
            <label>Email:</label><input type="email" name="email" required>
            <label>Password:</label><input type="password" name="password" required>
            <label>Address:</label><input type="text" name="address" required>
            <label>Role:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <p>Have an account? <a href="index.php">Login</a></p>
    </div>
</body>
</html>