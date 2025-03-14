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

// Fetch usage history for the customer
$sql = "SELECT * FROM Usage_History WHERE cust_id = $cust_id";
$result = $conn->query($sql);
?>

<h1>View Usage History</h1>
<table border="1">
    <tr>
        <th>Usage ID</th>
        <th>Usage Date</th>
        <th>Units Consumed</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['usage_id'] ?></td>
            <td><?= $row['usage_date'] ?></td>
            <td><?= $row['units_consumed'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No usage history found.</td>
        </tr>
    <?php endif; ?>
</table>

<?php include('../includes/footer.php'); ?>