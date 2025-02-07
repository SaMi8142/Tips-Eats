<?php
include 'connection.php'; // Include your database connection

$sql = "SELECT COUNT(*) AS report_sum FROM postreports";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode($row); // Return data as JSON
?>
