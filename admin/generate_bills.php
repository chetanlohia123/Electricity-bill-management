<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');
?>

<h1>Generate Bills</h1>
<form method="POST" action="generate_bills_logic.php">
    <label for="meter_id">Meter ID:</label>
    <input type="text" id="meter_id" name="meter_id" required>
    
    <label for="reading_value">Reading Value:</label>
    <input type="number" id="reading_value" name="reading_value" required>
    
    <button type="submit">Generate Bill</button>
</form>

<?php include('../includes/footer.php'); ?>