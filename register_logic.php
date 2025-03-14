<?php
session_start();
include('includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
// Check if the email already exists
$sql_check_email = "SELECT * FROM Customer WHERE email = '$email'";
$result_check_email = $conn->query($sql_check_email);

if ($result_check_email->num_rows > 0) {
    $_SESSION['error_message'] = "A customer with this email already exists.";
    header("Location: register.php");
    exit();
    } 
else {

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
}
?>