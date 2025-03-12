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

// Fetch meter readings for the customer
$sql = "SELECT * FROM Meter_Readings WHERE meter_id IN (SELECT meter_id FROM Meter WHERE cust_id = $cust_id)";
$result = $conn->query($sql);
?>

<h1>View Usage</h1>
<table border="1">
    <tr>
        <th>Reading ID</th>
        <th>Reading Date</th>
        <th>Reading Value</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['reading_id'] ?></td>
            <td><?= $row['reading_date'] ?></td>
            <td><?= $row['reading_value'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No usage data found.</td>
        </tr>
    <?php endif; ?>
</table>

<?php include('../includes/footer.php'); ?>