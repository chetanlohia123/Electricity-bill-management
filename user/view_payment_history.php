<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

// Retrieve the customer ID from the session
$cust_id = $_SESSION['cust_id'];

// Fetch payment history for the customer
$sql = "SELECT * FROM Payment_History WHERE cust_id = $cust_id";
$result = $conn->query($sql);
?>

<h1>View Payment History</h1>
<table border="1">
    <tr>
        <th>Payment ID</th>
        <th>Payment Date</th>
        <th>Amount Paid</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['payment_id'] ?></td>
            <td><?= $row['payment_date'] ?></td>
            <td><?= $row['amount_paid'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No payment history found.</td>
        </tr>
    <?php endif; ?>
</table>

<?php include('../includes/footer.php'); ?>