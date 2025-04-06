<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];

$stmt = $conn->prepare("SELECT usage_id, usage_date, units_consumed FROM Usage_History WHERE cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Usage</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>table { border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; }</style>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <h1>View Usage</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Usage ID</th>
                <th>Date</th>
                <th>Units Consumed</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['usage_id']; ?></td>
                    <td><?php echo $row['usage_date']; ?></td>
                    <td><?php echo $row['units_consumed']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No usage history found.</p>
    <?php endif; ?>
    <?php include('../includes/footer.php'); ?>
</body>
</html>