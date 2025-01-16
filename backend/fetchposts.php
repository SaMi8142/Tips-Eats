<?php
include 'connection.php';

$sql = "SELECT * FROM Posts ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '    <div class="post-container">';
        echo '        <div class="post-container-profile">';
        echo '            <div>';
        echo '                <img src="' . htmlspecialchars($row['profile_pic']) . '" alt="profile" class="profile">';
        echo '            </div>';
        echo '            <div class="post-container-content">';
        echo '                <h3>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . ' · ' . time_elapsed_string($row['date']) . '</h3>';
        echo '                <p>@' . htmlspecialchars($row['username']) . '</p>';
        echo '            </div>';
        echo '        </div>';
        echo '        <div class="post-container-body">';
        echo '            <pre>' . htmlspecialchars($row['post_content']) . '</pre>';
        echo '        </div>';
        if (!empty($row['post_pic'])) {
            echo '        <div class="post-container-img">';
            echo '            <img src="backend/' . htmlspecialchars($row['post_pic']) . '" alt="post image">';
            echo '            <div class="post-container-react">';
            echo '                <div class="post-container-react-buttons">';
            echo '                    <button class="like">Like</button>';
            echo '                    <button class="comment">Comment</button>';
            echo '                    <button class="follow">Follow</button>';
            echo '                    <button class="follow">Report</button>';
            echo '                    <button class="order">Make an order</button>';
            echo '                </div>';
            echo '            </div>';
            echo '        </div>';
        } else {
            echo '        <div class="post-container-react">';
            echo '            <div class="post-container-react-buttons">';
            echo '                <button class="like">Like</button>';
            echo '                <button class="comment">Comment</button>';
            echo '                <button class="follow">Follow</button>';
            echo '                    <button class="follow">Report</button>';
            echo '                <button class="order">Make an order</button>';
            echo '            </div>';
        }
        echo '    </div>';

    }
} else {
    echo 'No posts found.';
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
