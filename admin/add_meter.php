<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<h1>Add New Meter</h1>
<form method="POST" action="add_meter_logic.php">
    <label for="cust_id">Customer ID:</label>
    <input type="text" id="cust_id" name="cust_id" required>
    
    <label for="installation_date">Installation Date:</label>
    <input type="date" id="installation_date" name="installation_date" required>
    
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>
    
    <button type="submit">Add Meter</button>
</form>

<?php include('../includes/footer.php'); ?>