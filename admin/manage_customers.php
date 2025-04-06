<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$stmt = $conn->prepare("SELECT c.cust_id, c.cust_name, c.email, a.account_number 
                        FROM Customer c 
                        LEFT JOIN Account a ON c.cust_id = a.cust_id");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>Manage Customers</h1>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Account Number</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['cust_id']; ?></td>
                <td><?php echo $row['cust_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['account_number']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<link rel="stylesheet" href="css/styles.css">

<?php include('../includes/footer.php'); ?>