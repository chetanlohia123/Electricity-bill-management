<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<h1>User Dashboard</h1>
<p>Welcome, User!</p>
<ul>
    <li><a href="view_bills.php">View Bills</a></li>
    <li><a href="pay_bill.php">Pay Bill</a></li>
    <li><a href="view_usage.php">View Usage</a></li>
    <li><a href="submit_feedback.php">Submit Feedback</a></li>
</ul>

<?php include('../includes/footer.php'); ?>