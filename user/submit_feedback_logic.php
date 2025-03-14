<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];
$feedback = $_POST['feedback'];

// Insert feedback into database
$query = "INSERT INTO Feedback (cust_id, feedback) VALUES ($cust_id, '$feedback')";
if ($conn->query($query)) {
    $_SESSION['success_message'] = "Feedback submitted successfully!";
} else {
    $_SESSION['error_message'] = "Error: " . $conn->error;
}

header("Location: submit_feedback.php");
exit();
?>