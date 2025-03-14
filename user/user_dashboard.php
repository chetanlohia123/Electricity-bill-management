<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

include('../includes/db_connection.php'); // Ensure the database connection is included
include('../includes/header.php');

// Validate and sanitize cust_id
$cust_id = isset($_SESSION['cust_id']) ? intval($_SESSION['cust_id']) : 0;

if ($cust_id <= 0) {
    die("Invalid customer ID. Please log in again.");
}

// Fetch customer details using prepared statements
$query = "SELECT cust_name, email FROM Customer WHERE cust_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}

$stmt->bind_param("i", $cust_id); // Bind cust_id as an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    $cust_name = $customer['cust_name'];
    $cust_email = $customer['email'];
} else {
    // Handle case where customer details are not found
    $cust_name = "User";
    $cust_email = "N/A";
}

$stmt->close();
?>

<div class="dashboard-container">
    <h1>User Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($cust_name); ?>!</p>
    <p>Customer ID: <?php echo $cust_id; ?></p>
    <p>Email: <?php echo htmlspecialchars($cust_email); ?></p>

    <div class="dashboard-cards">
        <!-- View Bills -->
        <div class="card">
            <h3>View Bills</h3>
            <p>View and pay your electricity bills.</p>
            <a href="view_bills.php" class="btn btn-success">View Bills</a>
        </div>

        <!-- Pay Bill -->
        <div class="card">
            <h3>Pay Bill</h3>
            <p>Pay your electricity bills online.</p>
            <a href="pay_bill.php" class="btn btn-warning">Pay Bill</a>
        </div>

        <!-- View Usage -->
        <div class="card">
            <h3>View Usage</h3>
            <p>View your current electricity usage.</p>
            <a href="view_usage.php" class="btn btn-success">View Usage</a>
        </div>

        <!-- Submit Feedback -->
        <div class="card">
            <h3>Submit Feedback</h3>
            <p>Submit feedback to the electricity provider.</p>
            <a href="submit_feedback.php" class="btn btn-success">Submit Feedback</a>
        </div>

        <!-- Submit Complaint -->
        <div class="card">
            <h3>Submit Complaint</h3>
            <p>Submit a complaint or issue.</p>
            <a href="submit_complaint.php" class="btn btn-warning">Submit Complaint</a>
        </div>

        <!-- View Usage History -->
        <div class="card">
            <h3>View Usage History</h3>
            <p>View your historical usage data.</p>
            <a href="view_usage_history.php" class="btn btn-success">View Usage History</a>
        </div>

        <!-- View Payment History -->
        <div class="card">
            <h3>View Payment History</h3>
            <p>View your payment history.</p>
            <a href="view_payment_history.php" class="btn btn-success">View Payment History</a>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>