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
        header("Location: admin/admin_dashboard.php");
        exit();
    }

    // Check if customer
    $sql = "SELECT * FROM Customer WHERE email = '$login_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['cust_id'] = $login_id;
        header("Location: user/user_dashboard.php");
        exit();
    }

    echo "Invalid credentials!";
}
?>