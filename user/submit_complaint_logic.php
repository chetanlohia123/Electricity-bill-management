<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];
$complaint_text = $_POST['complaint_text'];

// Insert complaint into database
$query = "INSERT INTO complaint (cust_id, complaint_text, complaint_date, status) VALUES ($cust_id, '$complaint_text', CURDATE(), 'Pending')";
if ($conn->query($query)) {
    $_SESSION['success_message'] = "Complaint submitted successfully!";
} else {
    $_SESSION['error_message'] = "Error: " . $conn->error;
}

header("Location: submit_complaint.php");
exit();
?>
