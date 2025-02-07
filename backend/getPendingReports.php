<?php
include 'connection.php'; // Include your database connection

$sql = "SELECT COUNT(*) AS pending_sum FROM postreports WHERE status_report = 'Unresolved'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode($row); // Return data as JSON
?>
