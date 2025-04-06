<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');

if (isset($_POST['resolve'])) {
    $complaint_id = intval($_POST['complaint_id']);
    $stmt = $conn->prepare("UPDATE Complaint SET status = 'Resolved' WHERE complaint_id = ?");
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
}

$stmt = $conn->prepare("SELECT c.complaint_id, cu.cust_name, c.complaint_text, c.complaint_date, c.status 
                        FROM Complaint c 
                        JOIN Customer cu ON c.cust_id = cu.cust_id");
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1>Manage Complaints</h1>
    <table>
        <tr><th>ID</th><th>Customer</th><th>Complaint</th><th>Date</th><th>Status</th><th>Action</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['complaint_id']; ?></td>
                <td><?php echo $row['cust_name']; ?></td>
                <td><?php echo $row['complaint_text']; ?></td>
                <td><?php echo $row['complaint_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending'): ?>
                        <form method="post">
                            <input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">
                            <button type="submit" name="resolve" style="background: #4CAF50; color: white; border: none; padding: 5px;">Resolve</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<style>
    .container { max-width: 800px; margin: 20px auto; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #f2f2f2; }
</style>
<?php include('../includes/footer.php'); ?>