<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $cust_name = mysqli_real_escape_string($conn, $_POST['cust_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the email already exists
    $sql_check_email = "SELECT * FROM Customer WHERE email = '$email'";
    $result_check_email = $conn->query($sql_check_email);

    if ($result_check_email->num_rows > 0) {
        echo "Error: A customer with this email already exists.";
    } else {
        // Insert the new customer
        $sql = "INSERT INTO Customer (cust_name, email, address, password) VALUES ('$cust_name', '$email', '$address', '$password')";
        if ($conn->query($sql)) {
            header("Location: manage_customers.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>