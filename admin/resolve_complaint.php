<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = $_POST['complaint_id'];

    // Update the complaint status to "Resolved"
    $sql = "UPDATE Complaint SET status = 'Resolved' WHERE complaint_id = $complaint_id";
    if ($conn->query($sql)) {
        $_SESSION['success_message'] = "Complaint resolved successfully!";
    } else {
        $_SESSION['error_message'] = "Error resolving complaint: " . $conn->error;
    }

    header("Location: view_complaints.php");
    exit();
}
?>