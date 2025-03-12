<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

// Retrieve the customer ID from the session
$cust_id = $_SESSION['cust_id'];

// Fetch the account ID associated with the customer
$sql_account = "SELECT account_id FROM Account WHERE cust_id = $cust_id";
$result_account = $conn->query($sql_account);

if ($result_account->num_rows > 0) {
    $account = $result_account->fetch_assoc();
    $account_id = $account['account_id'];

    // Fetch invoices for the customer's account
    $sql_invoices = "SELECT * FROM Invoice WHERE account_id = $account_id";
    $result_invoices = $conn->query($sql_invoices);
} else {
    echo "No account found for this customer.";
    exit();
}
?>

<h1>View Bills</h1>
<table border="1">
    <tr>
        <th>Invoice ID</th>
        <th>Amount Due</th>
        <th>Due Date</th>
    </tr>
    <?php if ($result_invoices->num_rows > 0): ?>
        <?php while ($row = $result_invoices->fetch_assoc()): ?>
        <tr>
            <td><?= $row['invoice_id'] ?></td>
            <td><?= $row['amount_due'] ?></td>
            <td><?= $row['due_date'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No bills found.</td>
        </tr>
    <?php endif; ?>
</table>

<?php include('../includes/footer.php'); ?>