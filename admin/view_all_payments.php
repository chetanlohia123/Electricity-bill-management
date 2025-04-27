<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$stmt = $conn->prepare("SELECT p.payment_id, c.cust_name, p.bill_id, p.amount, p.payment_date 
                        FROM Payments p 
                        JOIN Bills b ON p.bill_id = b.bill_id
                        JOIN Account a ON b.account_id = a.account_id
                        JOIN Customer c ON a.cust_id = c.cust_id");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>All Payments</h1>
    <table>
        <tr><th>Payment ID</th><th>Customer</th><th>Bill ID</th><th>Amount</th><th>Date</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['payment_id']; ?></td>
                <td><?php echo $row['cust_name']; ?></td>
                <td><?php echo $row['bill_id']; ?></td>
                <td>$<?php echo $row['amount']; ?></td>
                <td><?php echo $row['payment_date']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<link rel="stylesheet" href="../css/styles.css">
<?php include('../includes/footer.php'); ?>
