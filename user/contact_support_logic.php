<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$issue_description = $_POST['issue_description'];

$stmt = $conn->prepare("INSERT INTO Customer_Support (cust_id, issue_description, support_date) VALUES (?, ?, CURDATE())");
$stmt->bind_param("is", $cust_id, $issue_description);
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Support request submitted!";
}
header("Location: contact_support.php");
exit();
?>