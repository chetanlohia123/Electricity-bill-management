<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_POST['cust_id'];
    $cust_name = $_POST['cust_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $sql = "UPDATE Customer SET cust_name = '$cust_name', email = '$email', address = '$address', password = '$password' WHERE cust_id = $cust_id";
    if ($conn->query($sql)) {
        header("Location: manage_customers.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>