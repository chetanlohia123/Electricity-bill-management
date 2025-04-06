<?php
$conn = new mysqli("localhost", "root", "newpassword", "electricity_bill_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>