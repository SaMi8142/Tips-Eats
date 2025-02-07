<?php

session_start();
include 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Update status to offline
    $update_stmt = $conn->prepare("UPDATE users SET status = 'offline' WHERE user_id = ?");
    $update_stmt->bind_param("i", $user_id);
    $update_stmt->execute();
    $update_stmt->close();
}

// Destroy session
session_destroy();
echo "User logged out successfully.";
?>
