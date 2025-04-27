<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

$stmt = $conn->prepare("SELECT ci.interaction_id, c.cust_name, ci.description, ci.interaction_date 
                        FROM Customer_Interaction ci 
                        JOIN Customer c ON ci.cust_id = c.cust_id 
                        WHERE ci.interaction_type = 'Feedback'
                        ORDER BY ci.interaction_date DESC");
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
                    <td><?php echo $row['interaction_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['cust_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo $row['interaction_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No feedback submitted yet.</p>
    <?php endif; ?>
</div>
<?php include('../includes/footer.php'); ?>
