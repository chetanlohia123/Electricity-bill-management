<?php
session_start();
include('includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    // Check if admin
    $sql = "SELECT * FROM Admin WHERE login_id = '$login_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_id'] = $login_id;
        $_SESSION['success_message'] = "Logged in successfully as Admin!";
        header("Location: admin/admin_dashboard.php");
        exit();
    }

    // Check if customer
    $sql = "SELECT cust_id FROM Customer WHERE email = '$login_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cust_id'] = $row['cust_id']; // Store cust_id in session
        $_SESSION['success_message'] = "Logged in successfully as User!";
        header("Location: user/user_dashboard.php");
        exit();
    }

    // If login fails
    $_SESSION['error_message'] = "Invalid credentials!";
    header("Location: index.php");
    exit();
}
?>