<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

// Set content type to JSON for AJAX response
header('Content-Type: application/json');

// Initialize the response array
$response = [];

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if all required fields are provided
        $requiredFields = ['post_id', 'user_id', 'comment_content', 'profile_pic', 'first_name', 'last_name', 'username'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        // Sanitize POST data
        $post_id = $conn->real_escape_string($_POST['post_id']);
        $user_id = $conn->real_escape_string($_POST['user_id']);
        $comment_content = $conn->real_escape_string($_POST['comment_content']);
        $profile_pic = $conn->real_escape_string($_POST['profile_pic']);
        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $username = $conn->real_escape_string($_POST['username']);

        // Insert the comment into the database
        $sql = "INSERT INTO Comments (post_id, user_id, comment_content, profile_pic, first_name, last_name, username, created_at)
                VALUES ('$post_id', '$user_id', '$comment_content', '$profile_pic', '$first_name', '$last_name', '$username', NOW())";

        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Comment added successfully!';
            $response['comment_id'] = $conn->insert_id;
        } else {
            throw new Exception("Database error: " . $conn->error);
        }
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Close the database connection
$conn->close();

// Return JSON response
echo json_encode($response);
?>