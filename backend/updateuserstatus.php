<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}
include 'connection.php'; // Ensure database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // Unauthorized access
    die("Unauthorized access. Please log in.");
}

// Get JSON input from sendBeacon
$data = json_decode(file_get_contents("php://input"), true);

// Validate data
if (!empty($data["status"])) {
    $userId = $_SESSION['user_id']; // Use session user ID

    // Update the user's status to offline
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE user_id = ?");
    $stmt->bind_param("si", $data["status"], $userId);
    $stmt->execute();
    $stmt->close();

    // Send a success response
    http_response_code(200);
    echo json_encode(["message" => "User status updated to offline."]);
} else {
    http_response_code(400); // Bad request
    echo json_encode(["message" => "Invalid request."]);
}
?>
