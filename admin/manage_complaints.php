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

if (isset($_POST['resolve'])) {
    $interaction_id = intval($_POST['interaction_id']);
    $stmt = $conn->prepare("UPDATE Customer_Interaction SET status = 'Resolved' WHERE interaction_id = ? AND interaction_type = 'Complaint'");
    $stmt->bind_param("i", $interaction_id);
    $stmt->execute();
    $_SESSION['success_message'] = "Complaint resolved successfully!";
    header("Location: manage_complaints.php");
    exit();
}

$stmt = $conn->prepare("SELECT ci.interaction_id, cu.cust_name, ci.description, ci.interaction_date, ci.status 
                        FROM Customer_Interaction ci 
                        JOIN Customer cu ON ci.cust_id = cu.cust_id 
                        WHERE ci.interaction_type = 'Complaint'
                        ORDER BY ci.interaction_date DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>Manage Complaints</h1>
    <?php if ($success_message): ?><p class="success"><?= $success_message ?></p><?php endif; ?>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr><th>ID</th><th>Customer</th><th>Complaint</th><th>Date</th><th>Status</th><th>Action</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['interaction_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['cust_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo $row['interaction_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <form method="post">
                                <input type="hidden" name="interaction_id" value="<?php echo $row['interaction_id']; ?>">
                                <button type="submit" name="resolve">Resolve</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No complaints found.</p>
    <?php endif; ?>
</div>
<?php include('../includes/footer.php'); ?>
