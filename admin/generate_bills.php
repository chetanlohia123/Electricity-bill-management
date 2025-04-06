<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
unset($_SESSION['success_message']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate'])) {
    $stmt = $conn->prepare("
        SELECT DISTINCT c.cust_id, a.account_id, m.meter_id, mr.units_consumed, t.rate
        FROM Customer c
        JOIN Account a ON c.cust_id = a.cust_id
        JOIN Meter m ON c.cust_id = m.cust_id
        JOIN Meter_Readings mr ON m.meter_id = mr.meter_id
        JOIN Tariff t ON t.tariff_id = 1
        LEFT JOIN Bills b ON b.cust_id = c.cust_id AND b.bill_date = mr.reading_date
        WHERE b.bill_id IS NULL
    ");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cust_id = $row['cust_id'];
        $account_id = $row['account_id'];
        $amount = $row['units_consumed'] * $row['rate'];
        $bill_date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime('+14 days'));

        $stmt = $conn->prepare("INSERT INTO Bills (cust_id, account_id, amount, bill_date, due_date, status) 
                                VALUES (?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iidds", $cust_id, $account_id, $amount, $bill_date, $due_date);
        $stmt->execute();
        $bill_id = $conn->insert_id;

        $message = "New bill (ID: $bill_id) issued for $$amount, due on $due_date.";
        $stmt = $conn->prepare("INSERT INTO Notification (cust_id, message, notification_date, status) 
                                VALUES (?, ?, ?, 'Pending')");
        $stmt->bind_param("iss", $cust_id, $message, $bill_date);
        $stmt->execute();
    }
    $_SESSION['success_message'] = "Bills generated successfully!";
    header("Location: generate_bills.php");
    exit();
}

$stmt = $conn->prepare("SELECT COUNT(*) AS pending_readings 
                        FROM Meter_Readings mr 
                        LEFT JOIN Bills b ON b.bill_date = mr.reading_date AND b.cust_id = (
                            SELECT cust_id FROM Meter m WHERE m.meter_id = mr.meter_id
                        )
                        WHERE b.bill_id IS NULL");
$stmt->execute();
$pending = $stmt->get_result()->fetch_assoc()['pending_readings'];
?>
<div class="container">
    <h1>Generate Bills</h1>
    <?php if ($success_message): ?><p class="success"><?= $success_message ?></p><?php endif; ?>
    <p>Pending Meter Readings to Bill: <?php echo $pending; ?></p>
    <form method="post">
        <button type="submit" name="generate">Generate Bills</button>
    </form>
    <h2>Recent Bills</h2>
    <?php
    $stmt = $conn->prepare("SELECT b.bill_id, c.cust_name, b.amount, b.bill_date, b.due_date 
                            FROM Bills b 
                            JOIN Customer c ON b.cust_id = c.cust_id 
                            ORDER BY b.bill_date DESC LIMIT 15");
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <table>
        <tr><th>Bill ID</th><th>Customer</th><th>Amount</th><th>Bill Date</th><th>Due Date</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['bill_id']; ?></td>
                <td><?php echo $row['cust_name']; ?></td>
                <td>$<?php echo $row['amount']; ?></td>
                <td><?php echo $row['bill_date']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include('../includes/footer.php'); ?>