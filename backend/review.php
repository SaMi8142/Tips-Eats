<?php
session_start();
include 'connection.php'; // Ensure this file contains a valid database connection ($conn)

$response = ["success" => false, "message" => ""];

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    $response["message"] = "User not logged in.";
    echo json_encode($response);
    exit;
}

// Get user details from the session
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"] ?? '';
$first_name = $_SESSION["first_name"] ?? '';
$last_name = $_SESSION["last_name"] ?? '';
$profile_pic = $_SESSION["profile_pic"] ?? '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"] ?? '';
    $review_content = $_POST["review_content"] ?? '';
    $rating = $_POST["rating"] ?? '';

    // Validate inputs
    if (empty($product_id) || empty($review_content) || empty($rating)) {
        $response["message"] = "All fields are required.";
    } else {
        // Insert review into the database
        $stmt = $conn->prepare("INSERT INTO Reviews (product_id, user_id, rating, review_content, profile_pic, first_name, last_name, username, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiisssss", $product_id, $user_id, $rating, $review_content, $profile_pic, $first_name, $last_name, $username);

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Review submitted successfully!";
        } else {
            $response["message"] = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();

// Return JSON response
echo json_encode($response);
?>
