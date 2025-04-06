<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

if (isset($_POST['add_tariff'])) {
    $category = $_POST['category'];
    $rate = floatval($_POST['rate']);
    $stmt = $conn->prepare("INSERT INTO Tariff (category, rate) VALUES (?, ?)");
    $stmt->bind_param("sd", $category, $rate);
    $stmt->execute();
}

$stmt = $conn->prepare("SELECT tariff_id, category, rate FROM Tariff");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>Manage Tariffs</h1>
    <form method="post" style="margin-bottom: 20px;">
        <label>Category:</label><input type="text" name="category" required>
        <label>Rate ($/unit):</label><input type="number" step="0.01" name="rate" required>
        <button type="submit" name="add_tariff" style="background: #4CAF50; color: white; border: none; padding: 10px;">Add Tariff</button>
    </form>
    <table>
        <tr><th>ID</th><th>Category</th><th>Rate</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['tariff_id']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td>$<?php echo $row['rate']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<link rel="stylesheet" href="css/styles.css">

<?php include('../includes/footer.php'); ?>