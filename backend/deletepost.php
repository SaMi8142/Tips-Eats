<?php
include 'connection.php';

// Check if post_id is set
if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Update the post status to 'dismissed'
    $update_sql = "UPDATE Posts SET status = 'dismissed' WHERE post_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        echo "Post status updated to dismissed successfully.";
    } else {
        echo "Error updating post status.";
    }

    $stmt->close();
} else {
    echo "Invalid post ID.";
}

$conn->close();
?>
