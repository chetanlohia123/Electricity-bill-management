<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

$meter_id = $_GET['id'];

// Delete related records first
$sql_delete_readings = "DELETE FROM Meter_Readings WHERE meter_id = $meter_id";
$sql_delete_invoices = "DELETE FROM Invoice WHERE meter_id = $meter_id";

$conn->query($sql_delete_readings);
$conn->query($sql_delete_invoices);

// Now delete the meter
$sql_delete_meter = "DELETE FROM Meter WHERE meter_id = $meter_id";
if ($conn->query($sql_delete_meter)) {
    header("Location: manage_meters.php");
} else {
    echo "Error: " . $sql_delete_meter . "<br>" . $conn->error;
}
?>