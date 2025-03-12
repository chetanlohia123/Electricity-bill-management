<?php
session_start();
include('includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == "admin") {
        $sql = "INSERT INTO Admin (login_id, password) VALUES ('$email', '$password')";
    } else {
        // Provide a default address if not provided in the form
        $address = isset($_POST['address']) ? $_POST['address'] : 'Not Provided';
        $sql = "INSERT INTO Customer (cust_name, email, password, address) VALUES ('$name', '$email', '$password', '$address')";
    }

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>