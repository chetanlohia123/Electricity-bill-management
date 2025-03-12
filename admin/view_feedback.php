<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');
include('../includes/header.php');
?>

<h1>View Feedback</h1>
<table border="1">
    <tr>
        <th>Feedback ID</th>
        <th>Customer ID</th>
        <th>Feedback Text</th>
        <th>Feedback Date</th>
    </tr>
    <?php
    $sql = "SELECT * FROM Feedback";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['feedback_id'] ?></td>
        <td><?= $row['cust_id'] ?></td>
        <td><?= $row['feedback_text'] ?></td>
        <td><?= $row['feedback_date'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('../includes/footer.php'); ?>