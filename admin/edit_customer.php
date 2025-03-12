<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$cust_id = $_GET['id'];
$sql = "SELECT * FROM Customer WHERE cust_id = $cust_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h1>Edit Customer</h1>
<form method="POST" action="edit_customer_logic.php">
    <input type="hidden" name="cust_id" value="<?= $row['cust_id'] ?>">
    
    <label for="cust_name">Name:</label>
    <input type="text" id="cust_name" name="cust_name" value="<?= $row['cust_name'] ?>" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= $row['email'] ?>" required>
    
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?= $row['address'] ?>" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="<?= $row['password'] ?>" required>
    
    <button type="submit">Update Customer</button>
</form>

<?php include('../includes/footer.php'); ?>