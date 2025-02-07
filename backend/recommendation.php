<?php
include 'connection.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

// Get the logged-in user ID
$logged_in_user_id = $_SESSION['user_id'];

$sql = "SELECT p.product_id, p.product_title, p.product_content, p.product_pic, p.price, p.date, p.user_id, u.username, u.first_name, u.last_name, u.profile_pic 
        FROM Products p 
        JOIN Users u ON p.user_id = u.user_id 
        WHERE p.status != 'dismissed'  -- Exclude products with status 'dismissed'
        AND p.user_id != $logged_in_user_id -- do not include logged-in user
        ORDER BY p.date DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

 echo '       <div class="recommended-card">
        <div class="recommended-card-header ">
            <div class="recommended-card-profile">
                <div>
                    <img src="backend/' . htmlspecialchars($row['profile_pic']) . '" class="profile"></img>
                </div>
                <div class="recommended-card-content">
                    <h3>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . ' </h3>
                    <p>@' . htmlspecialchars($row['username']) . '</p>
                </div>
            </div>
            <div class="recommended-card-body">
            <pre style="font-weight: bold">' . htmlspecialchars($row['product_title']) . '</pre>
               <div class="recommended-container-img">
               <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="post image">
               </div>
            </div>
            <div class="recommended-card-footer">
                <button onclick="orderRProduct( ' . htmlspecialchars($row['user_id']) . ', ' . htmlspecialchars($row['product_id']) . ')"> Book an Order</button>
            </div>
        </div>
    </div>';

    }
} else {
    echo '<center> Nothing to recommend yet....</center>';
}

mysqli_close($conn);

?>
