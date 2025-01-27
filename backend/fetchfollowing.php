<?php
include 'connection.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

$my_id = $_SESSION['user_id'];  

// Fetch all users except the logged-in user
$sql_users = "SELECT user_id, first_name, last_name, username, profile_pic FROM Users WHERE user_id != ?";
$stmt_users = $conn->prepare($sql_users);
$stmt_users->bind_param("i", $my_id);
$stmt_users->execute();
$result_users = $stmt_users->get_result();

if ($result_users->num_rows > 0) {
    while ($row_user = $result_users->fetch_assoc()) {
        $user_id = $row_user['user_id'];
        $first_name = htmlspecialchars($row_user['first_name']);
        $last_name = htmlspecialchars($row_user['last_name']);
        $username = htmlspecialchars($row_user['username']);
        $profile_pic = htmlspecialchars($row_user['profile_pic']);

        // Check if the logged-in user is already following this user
        $follow_check_sql = "SELECT 1 FROM Follows WHERE user_id = ? AND follower_id = $my_id";
        $follow_check_stmt = $conn->prepare($follow_check_sql);
        $follow_check_stmt->bind_param("i", $user_id);
        $follow_check_stmt->execute();
        $follow_check_result = $follow_check_stmt->get_result();
        $is_following = $follow_check_result->num_rows > 0;
        $follow_check_stmt->close();

        // Set follow button state based on whether the user is already following the author
        $follow_button_text = $is_following ? 'Unfollow' : 'Follow';
        $follow_button_class = $is_following ? 'following' : 'follow ';


        echo '<div class="following-card">';
        echo '    <div class="following-card-header ">';
        echo '        <div class="following-card-profile">';
        echo '            <div>';
        echo '                <img src="backend/' . $profile_pic . '" alt="profile" class="profile"></img>';
        echo '            </div>';
        echo '            <div class="following-card-content">';
        echo '                <h3>' . $first_name . ' ' . $last_name . '</h3>';
        echo '                <p>@' . $username . '</p>';
        echo '                <button class="following-button-' . $follow_button_class . '" id="follow-button-' . $user_id . '" onclick="toggleFollowing(' . $user_id .  ', ' . $my_id . ', ' . $user_id .  ')">' . $follow_button_text . '</button>';
        echo '            </div>';
        echo '        </div>';
        echo '        <div class="following-card-body">';
        echo '            <p>Traveling the world one bite at a time. Discovering and sharing the best local eats and hidden gems. 🌍🍴 #FoodieAdventures</p>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    echo '<p>No users found.</p>';
}

$stmt_users->close();

?>