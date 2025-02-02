<?php
include 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

$follower_id = $_SESSION['user_id'];  // Assuming the user is logged in and user_id is stored in session

// Query to get user_ids of users followed by the logged-in user
$followed_users_sql = "SELECT user_id FROM Follows WHERE follower_id = $follower_id";
$followed_users_result = $conn->query($followed_users_sql);

if ($followed_users_result === false) {
    die("Error: " . $conn->error);
}

$followed_user_ids = [];
while ($row = $followed_users_result->fetch_assoc()) {
    $followed_user_ids[] = $row['user_id'];
}

if (empty($followed_user_ids)) {
    echo '<center><p>No posts found, Follow someone...</p></center>';
    exit;
}

// Convert the array of followed user IDs to a comma-separated string
$followed_user_ids_str = implode(',', $followed_user_ids);

// Query to get posts from users followed by the logged-in user
$sql = "SELECT * FROM Posts WHERE user_id IN ($followed_user_ids_str) AND status != 'dismissed' ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $post_id = $row['post_id'];
        $user_id = $_SESSION['user_id'];  // Assuming the user is logged in and user_id is stored in session

        // Query to get the like count for this post
        $like_sql = "SELECT COUNT(*) AS like_count FROM Likes WHERE post_id = ?";
        $stmt = $conn->prepare($like_sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $like_result = $stmt->get_result();
        $like_row = $like_result->fetch_assoc();
        $like_count = $like_row['like_count'];
        $stmt->close();

        // Check if the user has already liked the post
        $like_check_sql = "SELECT 1 FROM Likes WHERE post_id = ? AND user_id = ?";
        $like_check_stmt = $conn->prepare($like_check_sql);
        $like_check_stmt->bind_param("ii", $post_id, $user_id);
        $like_check_stmt->execute();
        $like_check_result = $like_check_stmt->get_result();
        $has_liked = $like_check_result->num_rows > 0;
        $like_check_stmt->close();

        // Query to get the comment count for this post
        $comment_sql = "SELECT COUNT(*) AS comment_count FROM Comments WHERE post_id = ?";
        $comment_stmt = $conn->prepare($comment_sql);
        $comment_stmt->bind_param("i", $post_id);
        $comment_stmt->execute();
        $comment_result = $comment_stmt->get_result();
        $comment_row = $comment_result->fetch_assoc();
        $comment_count = $comment_row['comment_count'];
        $comment_stmt->close();

        // Check if the user is following the author of the post
        $follow_check_sql = "SELECT 1 FROM Follows WHERE user_id = ? AND follower_id = $user_id";
        $follow_check_stmt = $conn->prepare($follow_check_sql);
        $follow_check_stmt->bind_param("i", $row['user_id']);
        $follow_check_stmt->execute();
        $follow_check_result = $follow_check_stmt->get_result();
        $is_following = $follow_check_result->num_rows > 0;
        $follow_check_stmt->close();

        // Set button class and text based on whether the user has liked the post
        $button_class = $has_liked ? 'like liked' : 'like';
        $button_text = $has_liked ? 'Unlike' : 'Like';

        // Set follow button state based on whether the user is already following the author
        $follow_button_text = $is_following ? 'Unfollow' : 'Follow';
        $follow_button_class = $is_following ? 'follow following' : 'follow';

        echo '<div class="post-container">';
        echo '    <div class="post-container-profile">';
        echo '        <div>';
        echo '            <img src="' . htmlspecialchars($row['profile_pic']) . '" alt="profile" class="profile">';
        echo '        </div>';
        echo '        <div class="post-container-content">';
        echo '            <h3>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . ' · ' . time_elapsed_string($row['date']) . '</h3>';
        echo '            <p>@' . htmlspecialchars($row['username']) . '</p>';
        echo '        </div>';
        echo '    </div>';
        echo '    <div class="post-container-body">';
        echo '        <pre>' . htmlspecialchars($row['post_content']) . '</pre>';
        echo '    </div>';

        if ($user_id == $row['user_id']) {
            echo '    <div class="post-container-img">';
            echo '        <img src="backend/' . htmlspecialchars($row['post_pic']) . '" alt="post image">';
            echo '        <div class="post-container-react">';
            echo '            <div class="post-container-react-buttons">';
            echo '                <button class="' . $button_class . '" id="like-button-' . $post_id . '" onclick="toggleLike(' . $post_id . ')">';
            echo '                    ' . $button_text . '
                     </button>';
            echo '                <span class="count" id="like-count-' . $post_id . '">' . $like_count . '</span>';
            echo '                <button class="comment" onclick="openComment(' . htmlspecialchars($row['post_id']) . ')">Comment</button>';
            echo '                <span class="count" id="comment-count-' . $post_id . '">' . $comment_count . '</span>';
            echo '                <button class="follow" onclick="buttondeletepost(' . htmlspecialchars($row['post_id']) . ')">Delete</button>';
            echo '            </div>';
            echo '        </div>';
            echo '    </div>';
        } else {
            echo '    <div class="post-container-img">';
            echo '        <img src="backend/' . htmlspecialchars($row['post_pic']) . '" alt="post image">';
            echo '        <div class="post-container-react">';
            echo '            <div class="post-container-react-buttons">';
            echo '                <button class="' . $button_class . '" id="like-button-' . $post_id . '" onclick="toggleLike(' . $post_id . ')">';
            echo '                    ' . $button_text . '
                     </button>';
            echo '                <span class="count" id="like-count-' . $post_id . '">' . $like_count . '</span>';
            echo '                <button class="comment" onclick="openComment(' . htmlspecialchars($row['post_id']) . ')">Comment</button>';
            echo '                <span class="count" id="comment-count-' . $post_id . '">' . $comment_count . '</span>';
            echo '                <button class="' . $follow_button_class . '" id="follow-button-' . $row['post_id'] . '" onclick="togglefFollow(' . $row['user_id'] . ', ' . $user_id . ', ' . htmlspecialchars($row['post_id']) . ')">' . $follow_button_text . '</button>';
            echo '                    <button class="report" onclick="openReportPost(' . htmlspecialchars($row['user_id']) . ', ' . htmlspecialchars($row['post_id']) . ', \'' . htmlspecialchars($_SESSION['username']) . '\', \'' . htmlspecialchars($row['username']) . '\')">Report</button>';
            echo '            </div>';
            echo '        </div>';
            echo '    </div>';
        }
        echo '</div>';
    }
} else {
    echo '<center><h3>No posts found.</h3></center>';
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
