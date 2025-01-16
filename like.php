<?php
session_start();
include 'backend/connection.php';

$post_id = $_POST['post_id'] ?? null;
if ($post_id) {
    // Insert like
    $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $post_id]);
    
    // Fetch updated like count for the post
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $like_count = $stmt->fetchColumn();
    
    // Return the updated like count
    echo $like_count;
}
exit();
?>
