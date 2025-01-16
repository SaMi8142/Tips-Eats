<?php
session_start();
include 'backend/connection.php';

$post_id = $_POST['post_id'] ?? null;
$comment_text = $_POST['comment_text'] ?? '';

if ($post_id && $comment_text) {
    // Insert comment
    $stmt = $pdo->prepare("INSERT INTO comments (user_id, post_id, comment_text) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $post_id, $comment_text]);
    
    // Fetch updated comment count for the post
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM comments WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $comment_count = $stmt->fetchColumn();
    
    // Return the updated comment count
    echo $comment_count;
}
exit();
?>
