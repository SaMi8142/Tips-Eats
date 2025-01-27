<?php
// Include the database connection file
include 'connection.php';

// Set the response to JSON format
header('Content-Type: application/json');

// Start session to access `$_SESSION`
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input values from the POST request
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Assuming user_id is stored in session

    // Validate inputs
    if (!$post_id || !$action || !$user_id) {
        echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
        exit;
    }

    // Handle like and unlike actions
    if ($action === 'like') {
        // Insert the like into the Likes table
        $sql = "INSERT IGNORE INTO Likes (post_id, user_id) VALUES (?, ?)";
    } elseif ($action === 'unlike') {
        // Remove the like from the Likes table
        $sql = "DELETE FROM Likes WHERE post_id = ? AND user_id = ?";
    } else {
        // Invalid action
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        exit;
    }

    // Execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $user_id);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        exit;
    }
    $stmt->close();

    // Get the updated like count for the post
    $like_sql = "SELECT COUNT(*) AS like_count FROM Likes WHERE post_id = ?";
    $stmt = $conn->prepare($like_sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $like_row = $result->fetch_assoc();
    $like_count = $like_row['like_count'];
    $stmt->close();

    // Return the response with the updated like count
    echo json_encode(['success' => true, 'new_like_count' => $like_count]);
} else {
    // If the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>
