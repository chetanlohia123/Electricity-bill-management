<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

$cust_id = $_GET['id'];

// Delete related records first
$sql_delete_meters = "DELETE FROM Meter WHERE cust_id = $cust_id";
$sql_delete_invoices = "DELETE FROM Invoice WHERE account_id IN (SELECT account_id FROM Account WHERE cust_id = $cust_id)";
$sql_delete_feedback = "DELETE FROM Feedback WHERE cust_id = $cust_id";

$conn->query($sql_delete_meters);
$conn->query($sql_delete_invoices);
$conn->query($sql_delete_feedback);

// Now delete the customer
$sql_delete_customer = "DELETE FROM Customer WHERE cust_id = $cust_id";
if ($conn->query($sql_delete_customer)) {
    header("Location: manage_customers.php");
} else {
    echo "Error: " . $sql_delete_customer . "<br>" . $conn->error;
}
?>