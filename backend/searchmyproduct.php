<?php
// filepath: /d:/XAAMP/htdocs/Github/Tips-Eats/backend/searchproduct.php
include 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

// Get the logged-in user ID
$logged_in_user_id = $_SESSION['user_id'];

if (isset($_GET['query'])) {
    $query = $conn->real_escape_string($_GET['query']);

// Fetch products from the database based on the search query
$sql = "SELECT p.product_id, p.product_title, p.product_content, p.product_pic, p.price, p.date, p.user_id, 
               u.username, u.first_name, u.last_name, u.profile_pic 
        FROM Products p 
        JOIN Users u ON p.user_id = u.user_id 
        WHERE (p.product_title LIKE '%$query%' 
               OR p.product_content LIKE '%$query%' 
               OR u.username LIKE '%$query%' 
               OR u.first_name LIKE '%$query%' 
               OR u.last_name LIKE '%$query%' 
               OR DATE_FORMAT(p.date, '%Y-%m-%d') LIKE '%$query%') 
        AND p.status != 'dismissed'  -- Exclude dismissed posts
        AND p.user_id = $logged_in_user_id -- Filter by logged-in user
        ORDER BY p.date DESC";

$result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

        // Query to count reviews for the product
        $product_id = $row['product_id'];
        $review_count_sql = "SELECT COUNT(*) AS review_count FROM Reviews WHERE product_id = ?";
        $stmt = $conn->prepare($review_count_sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $review_result = $stmt->get_result();
        $review_row = $review_result->fetch_assoc();
        $review_count = $review_row['review_count'];
        $stmt->close();

            echo '<div class="post-container">';
            echo '    <div class="post-container-profile">';
            echo '        <div>';
            echo '            <img src="backend/' . htmlspecialchars($row['profile_pic']) . '" alt="profile" class="profile">';
            echo '        </div>';
            echo '        <div class="post-container-content">';
            echo '            <h3>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . ' · ' . time_elapsed_string($row['date']) . '</h3>';
            echo '            <p>@' . htmlspecialchars($row['username']) . '</p>';
            echo '        </div>';
            echo '    </div>';
            echo '    <div class="post-container-body">';
            echo '        <h5 class="product-title">' . htmlspecialchars($row['product_title']) . '</h5>';
            echo '        <pre>' . htmlspecialchars($row['product_content']) . '</pre>';
            echo '        <div class="post-container-img">';
            if (!empty($row['product_pic'])) {
                echo '            <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="product image">';
            }
            echo '            <div class="post-container-react">';
            echo '                <div class="post-container-react-buttons">';
            echo '                    <button class="price">P ' . htmlspecialchars($row['price']) . '</button>';

            if ($row['user_id'] == $logged_in_user_id) {
                echo '                    <button class="comment" onclick="openReviewProduct(' . htmlspecialchars($row['product_id']) . ')">Reviews</button>';
                echo '                    <span class="count" id="review-count">' . $review_count . '</span>';
                echo '                    <button class="report" onclick="openUpdateProduct(' . htmlspecialchars($row['product_id']) . ', \'' . addslashes($row['product_title']) . '\', \'' . addslashes($row['product_content']) . '\', ' . htmlspecialchars($row['price']) . ')">Update</button>';
                echo '                    <button class="report" onclick="deleteProduct(' . htmlspecialchars($row['product_id']) . ')">Delete</button>';
            } else {
                echo '                    <button class="order" onclick="orderProduct(' . htmlspecialchars($row['user_id']) . ', ' . htmlspecialchars($row['product_id']) . ')">Add to Cart</button>';
                echo '                    <button class="comment" onclick="openReviewProduct(' . htmlspecialchars($row['product_id']) . ')">Reviews</button>';
                echo '                    <span class="count" id="review-count">' . $review_count . '</span>';
                echo '                    <button class="report" onclick="openReportProduct(' . htmlspecialchars($row['user_id']) . ', ' . htmlspecialchars($row['product_id']) . ', \'' . htmlspecialchars($_SESSION['username']) . '\', \'' . htmlspecialchars($row['username']) . '\')">Report</button>';
            }
            echo '                </div>';
            echo '            </div>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo '<center>No products found.</center>';
    }

    mysqli_close($conn);
}

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