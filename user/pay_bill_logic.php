<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if (isset($_GET['invoice_id'])) {
    $invoice_id = $_GET['invoice_id'];

    // Fetch the invoice details
    $sql = "SELECT * FROM Invoice WHERE invoice_id = $invoice_id";
    $result = $conn->query($sql);
    $invoice = $result->fetch_assoc();

    // Insert payment record
    $payment_date = date('Y-m-d');
    $method_name = "Online Payment"; // You can change this based on the payment method
    $sql = "INSERT INTO Payment (bill_id, amount_paid, payment_date, method_name) VALUES ($invoice_id, {$invoice['amount_due']}, '$payment_date', '$method_name')";
    if ($conn->query($sql)) {
        echo "Payment successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>