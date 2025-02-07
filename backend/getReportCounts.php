<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tips&eats";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
}

$sql = "SELECT report_issue, COUNT(*) AS total_reports FROM postreports GROUP BY report_issue";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row; // Store each row as an array
}

mysqli_close($conn);

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
