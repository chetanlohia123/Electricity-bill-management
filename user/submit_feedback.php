<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
?>

<h1>Submit Feedback</h1>
<form method="POST" action="submit_feedback_logic.php">
    <label for="feedback_text">Feedback:</label>
    <textarea id="feedback_text" name="feedback_text" required></textarea>
    
    <button type="submit">Submit Feedback</button>
</form>

<?php include('../includes/footer.php'); ?>