<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meter_id = $_POST['meter_id'];
    $cust_id = $_POST['cust_id'];
    $installation_date = $_POST['installation_date'];
    $status = $_POST['status'];

    $sql = "UPDATE Meter SET cust_id = $cust_id, installation_date = '$installation_date', status = '$status' WHERE meter_id = $meter_id";
    if ($conn->query($sql)) {
        header("Location: manage_meters.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>