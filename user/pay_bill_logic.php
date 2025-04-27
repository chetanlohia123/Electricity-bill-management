<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$bill_id = intval($_POST['bill_id']);

// Check bill via Account
$stmt = $conn->prepare("SELECT b.* FROM Bills b 
                        JOIN Account a ON b.account_id = a.account_id 
                        WHERE b.bill_id = ? AND a.cust_id = ? AND b.status = 'Pending'");
$stmt->bind_param("ii", $bill_id, $cust_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $bill = $result->fetch_assoc();
    $amount = $bill['amount'];

    // Insert payment without cust_id
    $stmt = $conn->prepare("INSERT INTO Payments (bill_id, amount, payment_date) VALUES (?, ?, CURDATE())");
    $stmt->bind_param("id", $bill_id, $amount);
    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE Bills SET status = 'Paid' WHERE bill_id = ?");
        $stmt->bind_param("i", $bill_id);
        $stmt->execute();

        $_SESSION['success_message'] = "Payment successful!";
    } else {
        $_SESSION['error_message'] = "Payment failed: " . $conn->error;
    }
} else {
    $_SESSION['error_message'] = "No pending bill found or already paid.";
}
header("Location: pay_bill.php");
exit();
?>
