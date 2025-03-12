<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<h1>Add New Customer</h1>
<form method="POST" action="add_customer_logic.php">
    <label for="cust_name">Name:</label>
    <input type="text" id="cust_name" name="cust_name" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Add Customer</button>
</form>

<?php include('../includes/footer.php'); ?>