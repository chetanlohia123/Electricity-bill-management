<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>.success { color: green; } .error { color: redA; }</style>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <h1>Submit Feedback</h1>
    <?php if ($success_message): ?>
        <p class="success"><?= $success_message ?></p>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <p class="error"><?= $error_message ?></p>
    <?php endif; ?>
    <form action="submit_feedback_logic.php" method="post">
        <label for="feedback">Feedback:</label>
        <textarea name="feedback" id="feedback" required></textarea>
        <button type="submit">Submit</button>
    </form>
    <?php include('../includes/footer.php'); ?>
</body>
</html>