<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<h1>Admin Dashboard</h1>
<p>Welcome, Admin!</p>
<ul>
    <li><a href="manage_customers.php">Manage Customers</a></li>
    <li><a href="manage_meters.php">Manage Meters</a></li>
    <li><a href="generate_bills.php">Generate Bills</a></li>
    <li><a href="view_payments.php">View Payments</a></li>
    <li><a href="view_feedback.php">View Feedback</a></li>
</ul>

<?php include('../includes/footer.php'); ?>