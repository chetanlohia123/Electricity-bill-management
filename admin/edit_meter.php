<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$meter_id = $_GET['id'];
$sql = "SELECT * FROM Meter WHERE meter_id = $meter_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h1>Edit Meter</h1>
<form method="POST" action="edit_meter_logic.php">
    <input type="hidden" name="meter_id" value="<?= $row['meter_id'] ?>">
    
    <label for="cust_id">Customer ID:</label>
    <input type="text" id="cust_id" name="cust_id" value="<?= $row['cust_id'] ?>" required>
    
    <label for="installation_date">Installation Date:</label>
    <input type="date" id="installation_date" name="installation_date" value="<?= $row['installation_date'] ?>" required>
    
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Active" <?= $row['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
        <option value="Inactive" <?= $row['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
    
    <button type="submit">Update Meter</button>
</form>

<?php include('../includes/footer.php'); ?>