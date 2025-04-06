<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$stmt = $conn->prepare("SELECT f.feedback_id, c.cust_name, f.feedback_text, f.feedback_date 
                        FROM Feedback f 
                        JOIN Customer c ON f.cust_id = c.cust_id 
                        ORDER BY f.feedback_date DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>Customer Feedback</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr><th>Feedback ID</th><th>Customer</th><th>Feedback</th><th>Date</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['feedback_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['cust_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['feedback_text']); ?></td>
                    <td><?php echo $row['feedback_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No feedback submitted yet.</p>
    <?php endif; ?>
</div>
<?php include('../includes/footer.php'); ?>