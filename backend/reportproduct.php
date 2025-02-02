<?php
include 'connection.php'; // Database connection

if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from form
    $reported_id = $_POST['reported_user_id'] ?? 0;
    $product_id = $_POST['product_id'] ?? 0;
    $reporter_username = $_POST['reporter_username'] ?? '';
    $reported_username = $_POST['reported_username'] ?? '';
    $report_type = $_POST['report_type'] ?? 'Product';
    $report_issue = $_POST['report_issue'] ?? '';
    $report_description = $_POST['report_description'] ?? '';  // Get the report description

    // Validate required fields
    if (!$reported_id || !$product_id || empty($report_type) || empty($report_issue) || empty($report_description)) {
        die(json_encode(["success" => false, "message" => "Missing required fields"]));
    }

    // Insert report into ProductReports table with report_description
    $stmt = $conn->prepare("
        INSERT INTO ProductReports (product_id, reported_id, reporter_username, reported_username, report_type, report_issue, report_description) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisssss", $product_id, $reported_id, $reporter_username, $reported_username, $report_type, $report_issue, $report_description);
    $stmt->execute();
    $stmt->close();

    // Update product status to 'reported'
    $updateStmt = $conn->prepare("UPDATE Products SET status = 'reported' WHERE product_id = ?");
    $updateStmt->bind_param("i", $product_id);
    $updateStmt->execute();
    $updateStmt->close();

    echo json_encode(["success" => true, "message" => "Product reported successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>

