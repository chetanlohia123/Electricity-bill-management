<?php
session_start();
include('../includes/db_connection.php');
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
$cust_id = $_SESSION['cust_id'];
$bill_id = isset($_GET['bill_id']) ? intval($_GET['bill_id']) : 0;
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

$bill_details = null;
if ($bill_id > 0) {
    $stmt = $conn->prepare("SELECT b.*, a.account_number FROM Bills b 
                            JOIN Account a ON b.account_id = a.account_id 
                            WHERE b.bill_id = ? AND a.cust_id = ? AND b.status = 'Pending'");
    $stmt->bind_param("ii", $bill_id, $cust_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $bill_details = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Bill</title>
    <style>
        .container { max-width: 600px; margin: 20px auto; padding: 20px; }
        .success { color: green; } .error { color: red; }
        form { margin: 20px 0; }
        button { background: #4CAF50; color: white; padding: 10px; border: none; }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container">
        <h1>Pay Bill</h1>
        <?php if ($success_message): ?><p class="success"><?= $success_message ?></p><?php endif; ?>
        <?php if ($error_message): ?><p class="error"><?= $error_message ?></p><?php endif; ?>
        <form action="pay_bill.php" method="get">
            <label>Enter Bill ID:</label>
            <input type="number" name="bill_id" required>
            <button type="submit">Check Bill</button>
        </form>
        <?php if ($bill_details): ?>
            <div class="bill-details">
                <h2>Bill Details</h2>
                <p>Bill ID: <?php echo $bill_details['bill_id']; ?></p>
                <p>Account: <?php echo $bill_details['account_number']; ?></p>
                <p>Amount: $<?php echo $bill_details['amount']; ?></p>
                <p>Due Date: <?php echo $bill_details['due_date']; ?></p>
                <form action="pay_bill_logic.php" method="post">
                    <input type="hidden" name="bill_id" value="<?php echo $bill_details['bill_id']; ?>">
                    <button type="submit">Pay Now</button>
                </form>
            </div>
        <?php elseif ($bill_id > 0): ?>
            <p>No pending bill found for ID <?php echo $bill_id; ?>.</p>
        <?php endif; ?>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
