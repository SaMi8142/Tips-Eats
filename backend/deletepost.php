<?php
include 'connection.php';

// Check if post_id is set
if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Delete the post from the Posts table
    $delete_sql = "DELETE FROM Posts WHERE post_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post.";
    }

    $stmt->close();
} else {
    echo "Invalid post ID.";
}

$conn->close();
?>
