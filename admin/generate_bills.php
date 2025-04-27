<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

include('../includes/db_connection.php');
include('../includes/header.php');

date_default_timezone_set('UTC');
$success_message = null;
$error_message = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate'])) {
    $today = date('Y-m-d');
    $due_date = date('Y-m-d', strtotime('+14 days'));

    // Fetch only readings which are still pending
    $query = "
        SELECT mr.reading_id, a.account_id, mr.units_consumed, t.rate
        FROM Meter_Readings mr
        JOIN Meter m ON mr.meter_id = m.meter_id
        JOIN Customer c ON m.cust_id = c.cust_id
        JOIN Account a ON c.cust_id = a.cust_id
        JOIN Tariff t ON t.tariff_id = 1
        WHERE mr.billing_status = 'Pending'
    ";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $error_message = "Prepare failed: " . $conn->error;
    } elseif (!$stmt->execute()) {
        $error_message = "Failed to fetch meter readings: " . $stmt->error;
    } else {
        $result = $stmt->get_result();
        $bills_generated = 0;

        while ($row = $result->fetch_assoc()) {
            $reading_id = $row['reading_id'];
            $account_id = $row['account_id'];
            $units_consumed = $row['units_consumed'];
            $rate = $row['rate'];
            $amount = (float)($units_consumed * $rate);

            // Insert a new bill
            $insert_stmt = $conn->prepare("INSERT INTO Bills (account_id, amount, bill_date, due_date, status) VALUES (?, ?, ?, ?, 'Pending')");
            $insert_stmt->bind_param('idss', $account_id, $amount, $today, $due_date);

            if ($insert_stmt->execute()) {
                $bills_generated++;

                // After bill inserted, mark this reading as 'Billed'
                $update_stmt = $conn->prepare("UPDATE Meter_Readings SET billing_status = 'Billed' WHERE reading_id = ?");
                $update_stmt->bind_param('i', $reading_id);
                $update_stmt->execute();
                $update_stmt->close();
            } else {
                $error_message = "Failed to insert bill: " . $insert_stmt->error;
                break;
            }

            $insert_stmt->close();
        }

        if ($bills_generated > 0) {
            $_SESSION['success_message'] = "$bills_generated bills generated successfully!";
        } else {
            $_SESSION['error_message'] = "No new bills generated.";
        }
    }
    if ($stmt) {
        $stmt->close();
    }

    header("Location: generate_bills.php");
    exit();
}

// After refresh
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Fetch total pending readings again
$count_stmt = $conn->prepare("
    SELECT COUNT(*) AS pending
    FROM Meter_Readings mr
    JOIN Meter m ON mr.meter_id = m.meter_id
    JOIN Customer c ON m.cust_id = c.cust_id
    JOIN Account a ON c.cust_id = a.cust_id
");
$count_stmt->execute();
$pending = $count_stmt->get_result()->fetch_assoc()['pending'] ?? 0;
$count_stmt->close();
?>

<div class="container">
    <div class="header-bar">
        <a href="javascript:history.back()" class="back-btn">Back</a>
    </div>

    <h1>Generate Bills</h1>

    <?php if ($success_message): ?>
        <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <div class="card">
        <p>Pending Readings to Bill: <?php echo htmlspecialchars($pending); ?></p>
        <form method="post">
            <button type="submit" name="generate">Generate Bills</button>
        </form>
    </div>

    <h2>Recent Bills</h2>
    <div class="card">
        <?php
        $recent_stmt = $conn->prepare("
           SELECT b.bill_id, c.cust_name, b.amount, b.bill_date, b.due_date
FROM Bills b
JOIN Account a ON b.account_id = a.account_id
JOIN Customer c ON a.cust_id = c.cust_id
ORDER BY b.bill_id DESC
LIMIT 15
        ");
        $recent_stmt->execute();
        $result = $recent_stmt->get_result();
        ?>

        <table>
            <tr>
                <th>Bill ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Bill Date</th>
                <th>Due Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['bill_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['cust_name']); ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['bill_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <?php $recent_stmt->close(); ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php if ($conn) { $conn->close(); } ?>