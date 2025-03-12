<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');
?>

<h1>Manage Meters</h1>
<table border="1">
    <tr>
        <th>Meter ID</th>
        <th>Customer ID</th>
        <th>Installation Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php
    $sql = "SELECT * FROM Meter";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['meter_id'] ?></td>
        <td><?= $row['cust_id'] ?></td>
        <td><?= $row['installation_date'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <a href="edit_meter.php?id=<?= $row['meter_id'] ?>">Edit</a> |
            <a href="delete_meter.php?id=<?= $row['meter_id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="add_meter.php">Add New Meter</a>

<?php include('../includes/footer.php'); ?>