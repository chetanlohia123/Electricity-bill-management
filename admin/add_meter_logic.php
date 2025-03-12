<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_POST['cust_id'];
    $installation_date = $_POST['installation_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO Meter (cust_id, installation_date, status) VALUES ($cust_id, '$installation_date', '$status')";
    if ($conn->query($sql)) {
        header("Location: manage_meters.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>