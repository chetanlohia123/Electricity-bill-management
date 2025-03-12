<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meter_id = $_POST['meter_id'];
    $reading_value = $_POST['reading_value'];

    // Check if the meter exists
    $sql_check_meter = "SELECT * FROM Meter WHERE meter_id = $meter_id";
    $result = $conn->query($sql_check_meter);

    if ($result->num_rows > 0) {
        // Fetch the previous reading value
        $sql_previous_reading = "SELECT reading_value FROM Meter_Readings WHERE meter_id = $meter_id ORDER BY reading_date DESC LIMIT 1";
        $result_previous = $conn->query($sql_previous_reading);
        $previous_reading = $result_previous->fetch_assoc()['reading_value'];

        // Calculate units consumed
        $units_consumed = $reading_value - $previous_reading;

        // Calculate bill amount (assuming a rate of 5 per unit)
        $rate = 5;
        $amount_due = $units_consumed * $rate;

        // Insert the new reading
        $reading_date = date('Y-m-d');
        $sql_insert_reading = "INSERT INTO Meter_Readings (meter_id, reading_date, reading_value) VALUES ($meter_id, '$reading_date', $reading_value)";
        if ($conn->query($sql_insert_reading)) {
            // Insert the invoice
            $due_date = date('Y-m-d', strtotime('+30 days'));
            $sql_insert_invoice = "INSERT INTO Invoice (meter_id, amount_due, due_date) VALUES ($meter_id, $amount_due, '$due_date')";
            if ($conn->query($sql_insert_invoice)) {
                echo "Bill generated successfully!";
            } else {
                echo "Error: " . $sql_insert_invoice . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_insert_reading . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid meter ID.";
    }
}
?>