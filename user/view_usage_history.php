<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
$cust_id = $_SESSION['cust_id'];

$stmt = $conn->prepare("SELECT usage_id, usage_date, units_consumed FROM Usage_History WHERE cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
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
        <tr><td colspan="3">No usage history found.</td></tr>
    <?php endif; ?>
</table>
<?php include('../includes/footer.php'); ?>