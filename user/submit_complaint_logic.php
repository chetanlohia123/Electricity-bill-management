<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$complaint_text = $_POST['complaint_text'];
$interaction_type = 'Complaint';

$stmt = $conn->prepare("INSERT INTO Customer_Interaction (cust_id, interaction_type, description, interaction_date, status) VALUES (?, ?, ?, CURDATE(), 'Pending')");
$stmt->bind_param("iss", $cust_id, $interaction_type, $complaint_text);
if ($stmt->execute()) {
    $stmt = $conn->prepare("INSERT INTO Notification (cust_id, message, notification_date) VALUES (?, ?, CURDATE())");
    $message = "New complaint submitted.";
    $stmt->bind_param("is", $cust_id, $message);
    $stmt->execute();
    $_SESSION['success_message'] = "Complaint submitted!";
}
header("Location: submit_complaint.php");
exit();
?>
