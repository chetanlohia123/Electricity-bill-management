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
                        JOIN Customer c ON p.cust_id = c.cust_id");
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
<style>
    .container { max-width: 800px; margin: 20px auto; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #f2f2f2; }
</style>
<?php include('../includes/footer.php'); ?>