<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$stmt = $conn->prepare("SELECT b.bill_id, c.cust_name, b.amount, b.bill_date, b.due_date, b.status 
                        FROM Bills b 
                        JOIN Account a ON b.account_id = a.account_id
                        JOIN Customer c ON a.cust_id = c.cust_id
                        ORDER BY b.bill_id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>All Bills</h1>
    <table>
        <tr><th>Bill ID</th><th>Customer</th><th>Amount</th><th>Bill Date</th><th>Due Date</th><th>Status</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['bill_id']; ?></td>
                <td><?php echo $row['cust_name']; ?></td>
                <td>$<?php echo $row['amount']; ?></td>
                <td><?php echo $row['bill_date']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<link rel="stylesheet" href="../css/styles.css">
<?php include('../includes/footer.php'); ?>
