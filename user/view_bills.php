<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];

// Fetch bills for the customer
$query = "SELECT * FROM Bills WHERE cust_id = $cust_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Bills</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <h1>View Bills</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Bill ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['bill_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No bills found for this account.</p>
    <?php endif; ?>
    <?php include('../includes/footer.php'); ?>
</body>
</html>