<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];

$stmt = $conn->prepare("SELECT b.bill_id, b.amount, b.date, p.payment_date, p.amount AS paid_amount
                        FROM bills b
                        LEFT JOIN payments p ON b.bill_id = p.bill_id
                        WHERE b.cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Bills</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>table { border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; }</style>
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
                <th>Payment Date</th>
                <th>Paid Amount</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['bill_id']; ?></td>
                    <td>$<?php echo $row['amount']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['payment_date'] ?: 'Not Paid'; ?></td>
                    <td>$<?php echo $row['paid_amount'] ?: '0.00'; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No bills found.</p>
    <?php endif; ?>
    <?php include('../includes/footer.php'); ?>
</body>
</html>