<?php
session_start();
include 'connection.php';

// Check if product_id is provided via GET and is numeric
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Query to fetch reviews related to the given product
    $sql = "SELECT r.review_id, r.review_content, r.created_at, u.first_name, u.last_name, u.username, u.profile_pic, 
                   r.rating
            FROM Reviews r
            JOIN Users u ON r.user_id = u.user_id
            WHERE r.product_id = ?
            ORDER BY r.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id); // Bind the product_id to fetch related reviews
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through the reviews and output them
        while ($row = $result->fetch_assoc()) {
            $review_id = $row['review_id'];
            $review_content = htmlspecialchars($row['review_content']);
            $created_at = $row['created_at'];
            $first_name = htmlspecialchars($row['first_name']);
            $last_name = htmlspecialchars($row['last_name']);
            $username = htmlspecialchars($row['username']);
            $profile_pic = htmlspecialchars($row['profile_pic']);
            $rating = $row['rating'];

            // Format the review's timestamp
            $time_elapsed = time_elapsed_string($created_at);

            // Display the review
            echo '<div class="post-container">';
            echo '    <div class="comment-container-profile">';
            echo '        <div>';
            echo '            <img src="backend/' . $profile_pic . '" alt="profile" class="profile">';
            echo '        </div>';
            echo '        <div class="post-container-content">';
            echo '            <h3>' . $first_name . ' ' . $last_name . ' · ' . $time_elapsed . '</h3>';
            echo '            <p>@' . $username . '</p>';
            echo '        </div>';

            // Rating stars
            $stars = str_repeat('⭐', $rating);
            echo '    </div>';
            echo '    <div class="post-container-body">';
            echo '        <pre> ' . $stars . ' ' . $review_content . '</pre>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo '<p>No reviews yet.</p>';
    }

    $stmt->close();
} else {
    echo '<p>Invalid or missing product ID.</p>';
}

$conn->close();

// Function to calculate time elapsed
function time_elapsed_string($datetime, $full = false) {
    date_default_timezone_set('Asia/Manila'); // Set timezone manually

    $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $ago = new DateTime($datetime, new DateTimeZone('Asia/Manila'));
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
