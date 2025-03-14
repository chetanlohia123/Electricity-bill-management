<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <h1>Submit Feedback</h1>
    <form action="submit_feedback_logic.php" method="post">
        <label for="feedback">Feedback:</label>
        <textarea name="feedback" id="feedback" required></textarea>
        <button type="submit">Submit</button>
    </form>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
