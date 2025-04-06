<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$stmt = $conn->prepare("SELECT COUNT(*) AS customers FROM Customer");
$stmt->execute();
$customers = $stmt->get_result()->fetch_assoc()['customers'];

$stmt = $conn->prepare("SELECT COUNT(*) AS pending_bills FROM Bills WHERE status = 'Pending'");
$stmt->execute();
$pending_bills = $stmt->get_result()->fetch_assoc()['pending_bills'];

$stmt = $conn->prepare("SELECT COUNT(*) AS complaints FROM Complaint WHERE status = 'Pending'");
$stmt->execute();
$complaints = $stmt->get_result()->fetch_assoc()['complaints'];
?>
<div class="admin-dashboard">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin <?php echo htmlspecialchars($_SESSION['admin_id']); ?>!</p>
    <div class="summary">
        <h2>System Overview</h2>
        <p>Total Customers: <?php echo $customers; ?></p>
        <p>Pending Bills: <?php echo $pending_bills; ?></p>
        <p>Pending Complaints: <?php echo $complaints; ?></p>
    </div>
    <div class="dashboard-cards">
        <div class="card"><h3>Manage Customers</h3><a href="manage_customers.php">Go</a></div>
        <div class="card"><h3>Generate Bills</h3><a href="generate_bills.php">Go</a></div>
        <div class="card"><h3>View Bills</h3><a href="view_all_bills.php">Go</a></div>
        <div class="card"><h3>Manage Complaints</h3><a href="manage_complaints.php">Go</a></div>
        <div class="card"><h3>View Payments</h3><a href="view_all_payments.php">Go</a></div>
        <div class="card"><h3>Manage Tariffs</h3><a href="manage_tariffs.php">Go</a></div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>