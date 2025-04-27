<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');
$cust_id = intval($_SESSION['cust_id']);

$stmt = $conn->prepare("SELECT cust_name, email FROM Customer WHERE cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT * FROM Customer_Bill_Summary WHERE cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$summary = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT COUNT(*) AS notifications FROM Notification WHERE cust_id = ? AND status = 'Pending'");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$notifications = $stmt->get_result()->fetch_assoc()['notifications'];
?>
<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($customer['cust_name']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($customer['email']); ?></p>
    <p>Pending Notifications: <?php echo $notifications; ?></p>
    <div class="summary">
        <h2>Billing Summary</h2>
        <p>Total Bills: <?php echo $summary['total_bills']; ?></p>
        <p>Total Amount: $<?php echo number_format($summary['total_amount'], 2); ?></p>
        <p>Pending Amount: $<?php echo number_format($summary['pending_amount'], 2); ?></p>
    </div>
    <div class="dashboard-cards">
        <div class="card"><a href="view_bills.php"><h3>View Bills</h3></a></div>
        <div class="card"><a href="pay_bill.php"><h3>Pay Bill</h3></a></div>
        <div class="card"><a href="view_usage_history.php"><h3>Usage History</h3></a></div>
        <div class="card"><a href="submit_complaint.php"><h3>Submit Complaint</h3></a></div>
        <div class="card"><a href="submit_feedback.php"><h3>Submit Feedback</h3></a></div>
        <div class="card"><a href="view_payment_history.php"><h3>Payment History</h3></a></div>
        <div class="card"><a href="contact_support.php"><h3>Contact Support</h3></a></div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>
