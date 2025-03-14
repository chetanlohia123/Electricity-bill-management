<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');
?>

<div class="container fade-in">
    <h1>View Complaints</h1>

    <?php
    // Fetch all complaints from the database
    $sql = "SELECT c.complaint_id, c.cust_id, c.complaint_text, c.complaint_date, c.status, cu.cust_name 
            FROM Complaint c
            JOIN Customer cu ON c.cust_id = cu.cust_id
            ORDER BY c.complaint_date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>Complaint ID</th>
                    <th>Customer Name</th>
                    <th>Complaint</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['complaint_id'] ?></td>
                    <td><?= $row['cust_name'] ?></td>
                    <td><?= $row['complaint_text'] ?></td>
                    <td><?= $row['complaint_date'] ?></td>
                    <td>
                        <span class="status <?= strtolower($row['status']) ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <form method="POST" action="resolve_complaint.php" style="display:inline;">
                                <input type="hidden" name="complaint_id" value="<?= $row['complaint_id'] ?>">
                                <button type="submit" class="btn btn-resolve">Resolve</button>
                            </form>
                        <?php else: ?>
                            <span class="resolved">Resolved</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<p>No complaints found.</p>";
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>