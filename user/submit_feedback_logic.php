<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$feedback_text = $_POST['feedback_text'];
$interaction_type = 'Feedback';

$stmt = $conn->prepare("INSERT INTO Customer_Interaction (cust_id, interaction_type, description, interaction_date, status) VALUES (?, ?, ?, CURDATE(), 'Resolved')");
$stmt->bind_param("iss", $cust_id, $interaction_type, $feedback_text);
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Feedback submitted!";
}
header("Location: submit_feedback.php");
exit();
?>
<a href="javascript:history.back()" class="back-button">Back</a>