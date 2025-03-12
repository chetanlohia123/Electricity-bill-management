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
    <title>Register</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="register_logic.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            
            <label for="role">Register as:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>
</body>
</html>