<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$feedback_text = $_POST['feedback_text'];

$stmt = $conn->prepare("INSERT INTO Feedback (cust_id, feedback_text, feedback_date) VALUES (?, ?, CURDATE())");
$stmt->bind_param("is", $cust_id, $feedback_text);
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Feedback submitted!";
}
header("Location: submit_feedback.php");
exit();
?>