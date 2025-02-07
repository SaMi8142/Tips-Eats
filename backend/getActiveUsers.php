<?php
include 'connection.php'; // Include your database connection

$sql = "SELECT COUNT(*) AS active_users FROM users WHERE status = 'online' and is_admin = '0'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode($row); // Return data as JSON
?>
