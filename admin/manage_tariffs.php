<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

// Fetch all tariffs
$sql = "SELECT * FROM Tariff";
$result = $conn->query($sql);
?>

<h1>Manage Tariffs</h1>
<table border="1">
    <tr>
        <th>Tariff ID</th>
        <th>Category</th>
        <th>Rate</th>
        <th>Actions</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['tariff_id'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= $row['rate'] ?></td>
            <td>
                <a href="edit_tariff.php?id=<?= $row['tariff_id'] ?>">Edit</a> |
                <a href="delete_tariff.php?id=<?= $row['tariff_id'] ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No tariffs found.</td>
        </tr>
    <?php endif; ?>
</table>
<a href="add_tariff.php">Add New Tariff</a>

<?php include('../includes/footer.php'); ?>