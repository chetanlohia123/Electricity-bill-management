<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<h1>Submit Complaint</h1>
<form method="POST" action="submit_complaint_logic.php">
    <label for="complaint_text">Complaint:</label>
    <textarea id="complaint_text" name="complaint_text" required></textarea>
    
    <button type="submit">Submit Complaint</button>
</form>

<?php include('../includes/footer.php'); ?>