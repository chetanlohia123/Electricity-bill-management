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
    $complaint_id = intval($_POST['complaint_id']);
    $stmt = $conn->prepare("UPDATE Complaint SET status = 'Resolved' WHERE complaint_id = ?");
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $_SESSION['success_message'] = "Complaint resolved successfully!";
    header("Location: manage_complaints.php");
    exit();
}

$stmt = $conn->prepare("SELECT c.complaint_id, cu.cust_name, c.complaint_text, c.complaint_date, c.status 
                        FROM Complaint c 
                        JOIN Customer cu ON c.cust_id = cu.cust_id 
                        ORDER BY c.complaint_date DESC");
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
                    <td><?php echo $row['complaint_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['cust_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['complaint_text']); ?></td>
                    <td><?php echo $row['complaint_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <form method="post">
                                <input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">
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