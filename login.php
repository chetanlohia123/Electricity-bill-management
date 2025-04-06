<?php
session_start();
include('includes/db_connection.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT admin_id FROM Admin WHERE login_id = ? AND password = ?");
    $stmt->bind_param("ss", $login_id, $password);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['admin_id'] = $login_id;
        $_SESSION['success_message'] = "Welcome, Admin!";
        header("Location: admin/admin_dashboard.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT cust_id FROM Customer WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $login_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cust_id'] = $row['cust_id'];
        $_SESSION['success_message'] = "Welcome back!";
        header("Location: user/user_dashboard.php");
        exit();
    }

    $_SESSION['error_message'] = "Invalid credentials!";
    header("Location: index.php");
    exit();
}
?>