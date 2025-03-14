<?php
session_start();
include('../includes/db_connection.php');

if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];
$bill_id = isset($_GET['bill_id']) ? intval($_GET['bill_id']) : 0;
$bill_details = null;

// Fetch bill details if bill_id is provided
if ($bill_id > 0) {
    $query = "SELECT * FROM bills WHERE bill_id = $bill_id AND cust_id = $cust_id AND status = 'Pending'";
    $result = $conn->query($query);
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
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <h1>Pay Bill</h1>

    <!-- Form to enter bill_id -->
    <form action="pay_bill.php" method="get">
        <label for="bill_id">Enter Bill ID:</label>
        <input type="number" name="bill_id" id="bill_id" required>
        <button type="submit">Check Bill</button>
    </form>

    <?php if ($bill_details): ?>
        <!-- Display bill details -->
        <div class="bill-details">
            <h2>Bill Details</h2>
            <p>Bill ID: <?php echo $bill_details['bill_id']; ?></p>
            <p>Amount: <?php echo $bill_details['amount']; ?></p>
            <p>Date: <?php echo $bill_details['date']; ?></p>

            <!-- Form to pay the bill -->
            <form action="pay_bill_logic.php" method="post">
                <input type="hidden" name="bill_id" value="<?php echo $bill_details['bill_id']; ?>">
                <button type="submit">Pay Now</button>
            </form>
        </div>
    <?php elseif ($bill_id > 0): ?>
        <!-- Display message if no bill is found -->
        <p>No due payments found for the provided Bill ID.</p>
    <?php endif; ?>

    <?php include('../includes/footer.php'); ?>
</body>
</html>