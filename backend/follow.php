<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $follower_id = intval($_POST['follower_id']);
    $action = $_POST['action'];

    // Log the request for debugging
    error_log("Action: $action, User ID: $user_id, Follower ID: $follower_id");

    if ($action === 'follow') {
        $sql = "INSERT INTO Follows (user_id, follower_id) VALUES (?, ?)";
    } elseif ($action === 'unfollow') {
        $sql = "DELETE FROM Follows WHERE user_id = ? AND follower_id = ?";
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $follower_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        error_log("Database error: " . $stmt->error); // Log errors for debugging
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}