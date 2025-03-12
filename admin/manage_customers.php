<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');
?>

<h1>Manage Customers</h1>
<table border="1">
    <tr>
        <th>Customer ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php
    $sql = "SELECT * FROM Customer";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['cust_id'] ?></td>
        <td><?= $row['cust_name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['address'] ?></td>
        <td>
            <a href="edit_customer.php?id=<?= $row['cust_id'] ?>">Edit</a> |
            <a href="delete_customer.php?id=<?= $row['cust_id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="add_customers.php">Add New Customer</a>

<?php include('../includes/footer.php'); ?>