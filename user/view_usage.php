<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];

// Fetch usage history for the customer
$query = "SELECT * FROM Usage_History WHERE cust_id = $cust_id";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching usage history: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Usage History</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <h1>View Usage History</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Usage ID</th>
                <th>Meter ID</th>
                <th>Usage Date</th>
                <th>Units Consumed</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['usage_id']; ?></td>
                    <td><?php echo $row['meter_id']; ?></td>
                    <td><?php echo $row['usage_date']; ?></td>
                    <td><?php echo $row['units_consumed']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No usage history found for this account.</p>
    <?php endif; ?>

    <?php include('../includes/footer.php'); ?>
</body>
</html>