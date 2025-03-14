<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];
$bill_id = intval($_POST['bill_id']);

// Fetch bill details
$query = "SELECT * FROM bills WHERE bill_id = $bill_id AND cust_id = $cust_id AND status = 'Pending'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $bill_details = $result->fetch_assoc();

    // Insert payment into the payments table
    $amount = $bill_details['amount'];
    $payment_query = "INSERT INTO payments (cust_id, bill_id, amount, payment_date) VALUES ($cust_id, $bill_id, $amount, CURDATE())";
    if ($conn->query($payment_query)) {
        // Update bill status to 'Paid'
        $update_query = "UPDATE bills SET status = 'Paid' WHERE bill_id = $bill_id";
        $conn->query($update_query);
        $_SESSION['success_message'] = "Payment successful!";
    } else {
        $_SESSION['error_message'] = "Error processing payment: " . $conn->error;
    }
} else {
    $_SESSION['error_message'] = "No pending bill found for the provided Bill ID.";
}

header("Location: pay_bill.php");
exit();
?>