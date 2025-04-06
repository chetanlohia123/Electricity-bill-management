<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];

$stmt = $conn->prepare("SELECT payment_id, bill_id, amount, payment_date FROM Payments WHERE cust_id = ?");
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment History</title>
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Payment History</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr><th>Payment ID</th><th>Bill ID</th><th>Amount</th><th>Date</th></tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['payment_id']; ?></td>
                        <td><?php echo $row['bill_id']; ?></td>
                        <td>$<?php echo $row['amount']; ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No payment history found.</p>
        <?php endif; ?>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>