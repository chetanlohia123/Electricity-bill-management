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
    $support_id = intval($_POST['support_id']);
    $stmt = $conn->prepare("UPDATE Customer_Support SET resolution_status = 'Closed' WHERE support_id = ?");
    $stmt->bind_param("i", $support_id);
    $stmt->execute();
    $_SESSION['success_message'] = "Support request resolved successfully!";
    header("Location: view_support_requests.php");
    exit();
}

$stmt = $conn->prepare("SELECT cs.support_id, c.cust_name, cs.issue_description, cs.support_date, cs.resolution_status 
                        FROM Customer_Support cs 
                        JOIN Customer c ON cs.cust_id = c.cust_id 
                        ORDER BY cs.support_date DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>Customer Support Requests</h1>
    <?php if ($success_message): ?><p class="success"><?= $success_message ?></p><?php endif; ?>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr><th>ID</th><th>Customer</th><th>Issue</th><th>Date</th><th>Status</th><th>Action</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['support_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['cust_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['issue_description']); ?></td>
                    <td><?php echo $row['support_date']; ?></td>
                    <td><?php echo $row['resolution_status']; ?></td>
                    <td>
                        <?php if ($row['resolution_status'] == 'Open'): ?>
                            <form method="post">
                                <input type="hidden" name="support_id" value="<?php echo $row['support_id']; ?>">
                                <button type="submit" name="resolve">Resolve</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No support requests found.</p>
    <?php endif; ?>
</div>
<?php include('../includes/footer.php'); ?>