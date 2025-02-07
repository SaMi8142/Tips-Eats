<?php
include 'connection.php'; // Database connection

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure connection is working
    if (!$conn) {
        die("Database connection failed.");
    }

    // Retrieve form values
    $reported_id = $_POST['reported_user_id'] ?? 0;
    $post_id = $_POST['product_id'] ?? 0;
    $reporter_username = $_POST['reporter_username'] ?? '';
    $reported_username = $_POST['reported_username'] ?? '';
    $report_type = $_POST['report_type'] ?? '';
    $report_issue = $_POST['report_issue'] ?? '';
    $report_description = $_POST['report_description'] ?? '';

    // Validate required fields
    if (!$reported_id || !$post_id || empty($report_type) || empty($report_issue) || empty($report_description)) {
        die("<script>alert('Error: Missing required fields!'); window.history.back();</script>");
    }

    // Insert report into PostReports table
    $stmt = $conn->prepare("
        INSERT INTO PostReports (post_id, reported_id, reporter_username, reported_username, report_type, report_issue, report_description) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    if (!$stmt) {
        die("<script>alert('SQL Error: " . $conn->error . "'); window.history.back();</script>");
    }

    $stmt->bind_param("iisssss", $post_id, $reported_id, $reporter_username, $reported_username, $report_type, $report_issue, $report_description);
    
    if ($stmt->execute()) {
        // Update post or product status based on report type
        if ($report_type == "Post") {
            $updateStmt = $conn->prepare("UPDATE products SET status = 'reported' WHERE post_id = ?");
        } else {
            $updateStmt = $conn->prepare("UPDATE Products SET status = 'reported' WHERE product_id = ?");
        }
        
        if ($updateStmt) {
            $updateStmt->bind_param("i", $post_id);
            $updateStmt->execute();
            $updateStmt->close();
        }

        echo "<script>alert('Report submitted successfully.'); window.location.href = '../marketplace.php';</script>";
    
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
