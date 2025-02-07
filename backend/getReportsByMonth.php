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

// Query to count reports grouped by month
$sql = "SELECT DATE_FORMAT(date, '%Y-%M') AS report_month, COUNT(*) AS total_reports
        FROM postreports
        GROUP BY report_month
        ORDER BY report_month";

$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
