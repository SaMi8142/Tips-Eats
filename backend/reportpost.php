<?php

// the new reportpost that handles both products and post reports

include 'connection.php'; // Database connection

if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from form
    $reported_id = $_POST['reported_user_id'] ?? 0;
    $post_id = $_POST['product_id'] ?? 0;  // This should probably be 'post_id' rather than 'product_id' for consistency
    $reporter_username = $_POST['reporter_username'] ?? '';
    $reported_username = $_POST['reported_username'] ?? '';
    $report_type = $_POST['report_type'];
    $report_issue = $_POST['report_issue'] ?? '';
    $report_description = $_POST['report_description'] ?? '';  // Get the report description

    // Validate required fields
    if (!$reported_id || !$post_id || empty($report_type) || empty($report_issue) || empty($report_description)) {
        die(json_encode(["success" => false, "message" => "Missing required fields"]));
    }

    // Insert report into PostReports table, including report_description
    $stmt = $conn->prepare("
        INSERT INTO PostReports (post_id, reported_id, reporter_username, reported_username, report_type, report_issue, report_description) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisssss", $post_id, $reported_id, $reporter_username, $reported_username, $report_type, $report_issue, $report_description);
    $stmt->execute();
    $stmt->close();


if ($report_type == "Post"){
    // Update post status to 'reported'
    $updateStmt = $conn->prepare("UPDATE Posts SET status = 'reported' WHERE post_id = ?");
    $updateStmt->bind_param("i", $post_id);
    $updateStmt->execute();
    $updateStmt->close();
} else {
        // Update Products status to 'reported'
        $updateStmt = $conn->prepare("UPDATE Products SET status = 'reported' WHERE product_id = ?");
        $updateStmt->bind_param("i", $post_id);
        $updateStmt->execute();
        $updateStmt->close();
}

    echo json_encode(["success" => true, "message" => "reported successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
