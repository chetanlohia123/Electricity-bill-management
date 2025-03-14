<?php
session_start();
if (!isset($_SESSION['cust_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_SESSION['cust_id'];
    $feedback_text = mysqli_real_escape_string($conn, $_POST['feedback_text']);
    $feedback_date = date('Y-m-d');

    $sql = "INSERT INTO Feedback (cust_id, feedback_text, feedback_date) VALUES ($cust_id, '$feedback_text', '$feedback_date')";
    if ($conn->query($sql)) {
        $_SESSION['success_message'] = "Feedback submitted successfully!";
        header("Location: user_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: submit_feedback.php");
        exit();
    }
}
?>