<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];

$stmt = $conn->prepare("SELECT u.usage_id, u.usage_date, u.units_consumed, m.meter_number 
                        FROM Usage_History u 
                        JOIN Meter m ON u.meter_id = m.meter_id 
                        WHERE u.cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Usage History</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Usage History</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr><th>Usage ID</th><th>Meter</th><th>Date</th><th>Units Consumed</th></tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['usage_id']; ?></td>
                        <td><?php echo $row['meter_number']; ?></td>
                        <td><?php echo $row['usage_date']; ?></td>
                        <td><?php echo $row['units_consumed']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No usage history found.</p>
        <?php endif; ?>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>