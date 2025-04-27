<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$issue_description = $_POST['issue_description'];
$interaction_type = 'Support';

$stmt = $conn->prepare("INSERT INTO Customer_Interaction (cust_id, interaction_type, description, interaction_date, status) VALUES (?, ?, ?, CURDATE(), 'Open')");
$stmt->bind_param("iss", $cust_id, $interaction_type, $issue_description);
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Support request submitted!";
}
header("Location: contact_support.php");
exit();
?>
