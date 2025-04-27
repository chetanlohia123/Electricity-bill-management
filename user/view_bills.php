<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];

$stmt = $conn->prepare("SELECT b.bill_id, b.amount, b.bill_date, b.due_date, b.status, p.payment_date 
                        FROM Bills b 
                        JOIN Account a ON b.account_id = a.account_id 
                        LEFT JOIN Payments p ON b.bill_id = p.bill_id 
                        WHERE a.cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Bills</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Your Bills</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr><th>Bill ID</th><th>Amount</th><th>Bill Date</th><th>Due Date</th><th>Status</th><th>Paid On</th></tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['bill_id']; ?></td>
                        <td>$<?php echo $row['amount']; ?></td>
                        <td><?php echo $row['bill_date']; ?></td>
                        <td><?php echo $row['due_date']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['payment_date'] ?: 'Not Paid'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No bills found.</p>
        <?php endif; ?>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
