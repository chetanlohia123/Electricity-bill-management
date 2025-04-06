<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
unset($_SESSION['success_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Complaint</title>
    <style>
        .container { max-width: 600px; margin: 20px auto; }
        textarea { width: 100%; height: 100px; }
        button { background: #4CAF50; color: white; padding: 10px; border: none; }
        .success { color: green; }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Submit Complaint</h1>
        <?php if ($success_message): ?><p class="success"><?= $success_message ?></p><?php endif; ?>
        <form action="submit_complaint_logic.php" method="post">
            <label>Your Complaint:</label>
            <textarea name="complaint_text" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>