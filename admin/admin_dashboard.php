<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<div class="dashboard-container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin!</p>
    <div class="dashboard-cards">
        <div class="card">
            <h3>Manage Customers</h3>
            <p>Add, edit, or delete customer records.</p>
            <a href="manage_customers.php" class="btn btn-success">Go to Customers</a>
        </div>
        <div class="card">
            <h3>Manage Meters</h3>
            <p>Add, edit, or delete meters.</p>
            <a href="manage_meters.php" class="btn btn-success">Manage Meters</a>
        </div>
        <div class="card">
            <h3>Generate Bills</h3>
            <p>Generate electricity bills for customers.</p>
            <a href="generate_bills.php" class="btn btn-warning">Generate Bills</a>
        </div>
        <div class="card">
            <h3>View Payments</h3>
            <p>View all payment records.</p>
            <a href="view_payments.php" class="btn btn-success">View Payments</a>
        </div>
        <div class="card">
            <h3>View Feedback</h3>
            <p>View feedback submitted by customers.</p>
            <a href="view_feedback.php" class="btn btn-success">View Feedback</a>
        </div>
        <div class="card">
            <h3>View User Details</h3>
            <p>View full details of users.</p>
            <a href="view_check.php" class="btn btn-success">View Details</a>
        </div>
        <div class="card">
            <h3>Manage Tariffs</h3>
            <p>Add, edit, or delete tariff rates.</p>
            <a href="manage_tariffs.php" class="btn btn-success">Manage Tariffs</a>
        </div>
        <div class="card">
            <h3>View Complaints</h3>
            <p>View and resolve customer complaints.</p>
            <a href="view_complaints.php" class="btn btn-warning">View Complaints</a>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>