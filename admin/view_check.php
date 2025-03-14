<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

// Fetch all user details from the User_Check table
$sql = "SELECT * FROM User_Check";
$result = $conn->query($sql);
?>

<h1>View User Details</h1>
<table border="1">
    <tr>
        <th>Customer ID</th>
        <th>Meter ID</th>
        <th>Balance to Pay</th>
        <th>Balance Paid</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['cust_id'] ?></td>
            <td><?= $row['meter_id'] ?></td>
            <td><?= $row['balance_to_pay'] ?></td>
            <td><?= $row['balance_paid'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No user details found.</td>
        </tr>
    <?php endif; ?>
</table>

<?php include('../includes/footer.php'); ?>