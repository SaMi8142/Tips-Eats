<?php
include 'connection.php';
session_start();

// Check if post_id is provided via GET or POST and is numeric
if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Query to fetch comments related to the given post
    $sql = "SELECT c.comment_id, c.comment_content, c.created_at, u.first_name, u.last_name, u.username, u.profile_pic, 
                   (SELECT COUNT(*) FROM commentlikes WHERE comment_id = c.comment_id) AS like_count
            FROM Comments c
            JOIN Users u ON c.user_id = u.user_id
            WHERE c.post_id = ? 
            ORDER BY c.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id); // Bind the post_id to fetch related comments
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through the comments and output them
        while ($row = $result->fetch_assoc()) {
            $comment_id = $row['comment_id'];
            $comment_content = htmlspecialchars($row['comment_content']);
            $created_at = $row['created_at'];
            $first_name = htmlspecialchars($row['first_name']);
            $last_name = htmlspecialchars($row['last_name']);
            $username = htmlspecialchars($row['username']);
            $profile_pic = htmlspecialchars($row['profile_pic']);
            $like_count = $row['like_count'];

            // Check if the user has already liked the comment
            $like_check_sql = "SELECT 1 FROM commentlikes WHERE comment_id = ? AND user_id = $user_id";
            $like_check_stmt = $conn->prepare($like_check_sql);
            $like_check_stmt->bind_param("i", $comment_id); // Bind only $comment_id since $user_id is hardcoded
            $like_check_stmt->execute();
            $like_check_result = $like_check_stmt->get_result();
            $liked_by_user = $like_check_result->num_rows > 0;
            $like_check_stmt->close();

            

            // Format the comment's timestamp
            $time_elapsed = time_elapsed_string($created_at);

            // Set button text and class based on whether the user has liked the comment
            $like_button_text = $liked_by_user ? 'Unlike' : 'Like';
            $like_button_class = $liked_by_user ? 'liked' : '';  // Add 'liked' class if the user already liked it

            // Display the comment
            echo '<div class="post-container">';
            echo '    <div class="comment-container-profile">';
            echo '        <div>';
            echo '            <img src="backend/' . $profile_pic . '" alt="profile" class="profile">';
            echo '        </div>';
            echo '        <div class="post-container-content">';
            echo '            <h3>' . $first_name . ' ' . $last_name . ' · ' . $time_elapsed . '</h3>';
            echo '            <p>@' . $username . '</p>';
            echo '        </div>';

            // Like button with dynamic text and class
            echo '        <button class="comment-like ' . $like_button_class . '" id="comment-like-' . $comment_id . '" data-comment-id="' . $comment_id . '" onclick="toggleCommentLike(' . $comment_id . ')">' . $like_button_text . '</button>';
            echo '        <span class="comment-like-count" id="comment-like-count-' . $comment_id . '">' . $like_count . '</span>';            
            echo '    </div>';
            echo '    <div class="post-container-body">';
            echo '        <pre>' . $comment_content . '</pre>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo '<p>No comments yet.</p>';
    }

    $stmt->close();
} else {
    echo '<p>Invalid or missing post ID.</p>';
}

$conn->close();

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
