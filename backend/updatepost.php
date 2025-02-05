<?php
session_start();
include 'connection.php'; // Ensure this file contains the correct DB connection

header('Content-Type: application/json'); // Return JSON response

$response = ["success" => false, "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['update_post_id'], $_POST['update_content'])) {
        $post_id = intval($_POST['update_post_id']);
        $post_content = trim($_POST['update_content']);

        // Validate input
        if ($post_id <= 0 || empty($post_content)) {
            echo json_encode(["success" => false, "message" => "Invalid post data"]);
            exit;
        }

        // Prepare and execute update query
        $stmt = $conn->prepare("UPDATE Posts SET post_content = ? WHERE post_id = ?");
        $stmt->bind_param("si", $post_content, $post_id);

        if ($stmt->execute()) {
            $response = ["success" => true, "message" => "Post updated successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to update post"];
        }

        $stmt->close();
    } else {
        $response = ["success" => false, "message" => "Missing required fields"];
    }
}

// Close DB connection
$conn->close();
echo json_encode($response);
?>
