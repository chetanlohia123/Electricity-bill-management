<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<div class="dashboard-container">
    <h1>User Dashboard</h1>
    <p>Welcome, User!</p>
    <div class="dashboard-cards">
        <div class="card">
            <h3>View Bills</h3>
            <p>View and pay your electricity bills.</p>
            <a href="view_bills.php" class="btn btn-success">View Bills</a>
        </div>
        <div class="card">
            <h3>Pay Bill</h3>
            <p>Pay your electricity bills online.</p>
            <a href="pay_bill.php" class="btn btn-warning">Pay Bill</a>
        </div>
        <div class="card">
            <h3>View Usage</h3>
            <p>View your current electricity usage.</p>
            <a href="view_usage.php" class="btn btn-success">View Usage</a>
        </div>
        <div class="card">
            <h3>Submit Feedback</h3>
            <p>Submit feedback to the electricity provider.</p>
            <a href="submit_feedback.php" class="btn btn-success">Submit Feedback</a>
        </div>
        <div class="card">
            <h3>Submit Complaint</h3>
            <p>Submit a complaint or issue.</p>
            <a href="submit_complaint.php" class="btn btn-warning">Submit Complaint</a>
        </div>
        <div class="card">
            <h3>View Usage History</h3>
            <p>View your historical usage data.</p>
            <a href="view_usage_history.php" class="btn btn-success">View Usage History</a>
        </div>
        <div class="card">
            <h3>View Payment History</h3>
            <p>View your payment history.</p>
            <a href="view_payment_history.php" class="btn btn-success">View Payment History</a>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>