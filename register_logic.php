<?php
session_start();
include('includes/db_connection.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address']; // Assuming address is a simple string
    $role = $_POST['role'];

    // Check if email already exists
    $stmt = $conn->prepare("SELECT cust_id FROM Customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['error_message'] = "Email already registered!";
        header("Location: register.php");
        exit();
    }

    if ($role == "admin") {
        $stmt = $conn->prepare("INSERT INTO Admin (login_id, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
    } else {
        // Insert into Address table first
        $stmt = $conn->prepare("INSERT INTO Address (street) VALUES (?)");
        $stmt->bind_param("s", $address);
        $stmt->execute();
        $address_id = $conn->insert_id;

        // Insert into Customer with address_id
        $stmt = $conn->prepare("INSERT INTO Customer (cust_name, address_id, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $address_id, $email, $password);
        $stmt->execute();
        $cust_id = $conn->insert_id;

        // Create Account and Meter entries (unchanged)
        $account_number = "ACC" . str_pad($cust_id, 6, "0", STR_PAD_LEFT);
        $stmt = $conn->prepare("INSERT INTO Account (cust_id, account_number) VALUES (?, ?)");
        $stmt->bind_param("is", $cust_id, $account_number);
        $stmt->execute();

        $meter_number = "MTR" . str_pad($cust_id, 6, "0", STR_PAD_LEFT);
        $stmt = $conn->prepare("INSERT INTO Meter (cust_id, meter_number, installation_date) VALUES (?, ?, CURDATE())");
        $stmt->bind_param("is", $cust_id, $meter_number);
        $stmt->execute();
    }
    $_SESSION['success_message'] = "Registered Successfully!";
    header("Location: index.php");
    exit();
}
?>
