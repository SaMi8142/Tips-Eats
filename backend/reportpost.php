<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php'; // Ensure this connects properly

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json'); // Ensure the response is JSON format

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate connection
    if (!$conn) {
        die(json_encode(["success" => false, "message" => "Database connection failed"]));
    }

    // Get values from form
    $reported_id = $_POST['reported_user_id'] ?? 0;
    $post_id = $_POST['post_id'] ?? ($_POST['product_id'] ?? 0);
    $reporter_username = $_POST['reporter_username'] ?? '';
    $reported_username = $_POST['reported_username'] ?? '';
    $report_type = $_POST['report_type'] ?? '';
    $report_issue = $_POST['report_issue'] ?? '';
    $report_description = $_POST['report_description'] ?? '';

    // Validate required fields
    if (!$reported_id || !$post_id || empty($report_type) || empty($report_issue) || empty($report_description)) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit();
    }

    // Insert into PostReports table
    $stmt = $conn->prepare("
        INSERT INTO PostReports (post_id, reported_id, reporter_username, reported_username, report_type, report_issue, report_description) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "SQL Prepare Error: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("iisssss", $post_id, $reported_id, $reporter_username, $reported_username, $report_type, $report_issue, $report_description);
    
    if ($stmt->execute()) {
        // Update post/product status
        if ($report_type == "Post") {
            $updateStmt = $conn->prepare("UPDATE Posts SET status = 'reported' WHERE post_id = ?");
        } else {
            $updateStmt = $conn->prepare("UPDATE Products SET status = 'reported' WHERE product_id = ?");
        }
        
        if ($updateStmt) {
            $updateStmt->bind_param("i", $post_id);
            $updateStmt->execute();
            $updateStmt->close();
        }

        echo json_encode(["success" => true, "message" => "Reported successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to report", "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

?>
