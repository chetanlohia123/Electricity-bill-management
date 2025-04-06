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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_reading'])) {
    $meter_id = intval($_POST['meter_id']);
    $units_consumed = intval($_POST['units_consumed']);
    $reading_date = $_POST['reading_date'];

    $stmt = $conn->prepare("INSERT INTO Meter_Readings (meter_id, reading_date, units_consumed) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $meter_id, $reading_date, $units_consumed);
    if ($stmt->execute()) {
        $stmt = $conn->prepare("INSERT INTO Usage_History (cust_id, meter_id, usage_date, units_consumed) 
                                SELECT cust_id, ?, ?, ? FROM Meter WHERE meter_id = ?");
        $stmt->bind_param("isii", $meter_id, $reading_date, $units_consumed, $meter_id);
        $stmt->execute();
        $_SESSION['success_message'] = "Meter reading added successfully!";
    }
    header("Location: manage_meter_readings.php");
    exit();
}

$stmt = $conn->prepare("SELECT m.meter_id, c.cust_name, m.meter_number 
                        FROM Meter m 
                        JOIN Customer c ON m.cust_id = c.cust_id");
$stmt->execute();
$meters = $stmt->get_result();
?>
<div class="container">
    <h1>Manage Meter Readings</h1>
    <?php if ($success_message): ?><p class="success"><?= $success_message ?></p><?php endif; ?>
    <form method="post">
        <label for="meter_id">Select Meter:</label>
        <select id="meter_id" name="meter_id" required>
            <?php while ($row = $meters->fetch_assoc()): ?>
                <option value="<?php echo $row['meter_id']; ?>">
                    <?php echo $row['meter_number'] . " (" . $row['cust_name'] . ")"; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label for="reading_date">Reading Date:</label>
        <input type="date" id="reading_date" name="reading_date" required>
        <label for="units_consumed">Units Consumed:</label>
        <input type="number" id="units_consumed" name="units_consumed" required min="0">
        <button type="submit" name="add_reading">Add Reading</button>
    </form>
    <h2>Recent Readings</h2>
    <?php
    $stmt = $conn->prepare("SELECT mr.reading_id, m.meter_number, c.cust_name, mr.reading_date, mr.units_consumed 
                            FROM Meter_Readings mr 
                            JOIN Meter m ON mr.meter_id = m.meter_id 
                            JOIN Customer c ON m.cust_id = c.cust_id 
                            ORDER BY mr.reading_date DESC LIMIT 15");
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <table>
        <tr><th>Reading ID</th><th>Meter</th><th>Customer</th><th>Date</th><th>Units</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['reading_id']; ?></td>
                <td><?php echo $row['meter_number']; ?></td>
                <td><?php echo $row['cust_name']; ?></td>
                <td><?php echo $row['reading_date']; ?></td>
                <td><?php echo $row['units_consumed']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include('../includes/footer.php'); ?>