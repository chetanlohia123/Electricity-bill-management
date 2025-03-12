<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');
?>

<h1>View Payments</h1>
<table border="1">
    <tr>
        <th>Payment ID</th>
        <th>Bill ID</th>
        <th>Amount Paid</th>
        <th>Payment Date</th>
        <th>Payment Method</th>
    </tr>
    <?php
    $sql = "SELECT * FROM Payment";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['payment_id'] ?></td>
        <td><?= $row['bill_id'] ?></td>
        <td><?= $row['amount_paid'] ?></td>
        <td><?= $row['payment_date'] ?></td>
        <td><?= $row['method_name'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('../includes/footer.php'); ?>