<?php
// Database connection
include 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

// Get the logged-in user ID
$logged_in_user_id = $_SESSION['user_id'];

if (isset($_GET['query'])) {
    $query = $conn->real_escape_string($_GET['query']);

        // Fetch orders from the database with conditional ordering by buyer_status and seller_status
        $sql = "SELECT o.order_id, o.product_id, o.order_title, o.order_price, o.order_quantity, o.order_finalprice, o.order_status, o.buyer_city, o.buyer_number, o.seller_city, o.ordered_at, o.buyer_status, o.seller_status, p.product_pic, p.product_title, p.price, 
        ub.first_name AS buyer_first_name, ub.last_name AS buyer_last_name, ub.username AS buyer_username, ub.profile_pic AS buyer_profile_pic, ub.region AS buyer_region, ub.province AS buyer_province, ub.city AS buyer_city, ub.barangay AS buyer_barangay, ub.phone AS buyer_phone,ub.street AS buyer_street,
        us.first_name AS seller_first_name, us.last_name AS seller_last_name, us.username AS seller_username, us.profile_pic AS seller_profile_pic, us.region AS seller_region, us.province AS seller_province, us.city AS seller_city, us.barangay AS seller_barangay, us.phone AS seller_phone,
               CASE
                    WHEN o.buyer_status = 'confirmed' AND o.seller_status = 'approved' THEN 1  
                    WHEN o.buyer_status = 'confirmed' AND o.seller_status = 'pending' THEN 2 
                    WHEN o.seller_status = 'pending' AND o.buyer_status = 'pending' THEN 3 
                    WHEN o.seller_status = 'rejected' AND o.buyer_status = 'confirmed' THEN 4 
                    WHEN o.buyer_status = 'cancelled' THEN 5 
                    ELSE 6  -- Any other case
                END AS order_priority
        FROM Orders o 
        JOIN Products p ON o.product_id = p.product_id 
        JOIN Users ub ON o.buyer_id = ub.user_id 
        JOIN Users us ON o.seller_id = us.user_id 
        WHERE o.seller_id = '$logged_in_user_id' 
        AND (o.order_title LIKE '%$query%' 
        OR o.order_id LIKE '%$query%' 
        OR ub.username LIKE '%$query%' 
        OR ub.city LIKE '%$query%' 
        OR o.ordered_at LIKE '%$query%' 
        OR ub.province LIKE '%$query%' 
        OR ub.region LIKE '%$query%' 
        OR o.order_status LIKE '%$query%' 
        OR o.seller_status LIKE '%$query%')
        AND (o.buyer_status = 'cancelled' OR o.buyer_status = 'confirmed')
        ORDER BY order_priority, o.ordered_at DESC";
        $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // Additional conditions
            if ($row['buyer_status'] == 'confirmed' && $row['seller_status'] == 'pending') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Buyer: @' . htmlspecialchars($row['buyer_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['buyer_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['buyer_street']) . ' ' . htmlspecialchars($row['buyer_barangay']) . ', ' . htmlspecialchars($row['buyer_city']) . ', ' . htmlspecialchars($row['buyer_province']) . ', ' . htmlspecialchars($row['buyer_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '    <div class="order-button-bar">';
                echo '        <p class="order-status">Under-Review</p>';
                echo '        <button class="order-delete-button" onclick="updatesellerReject(' . htmlspecialchars($row['order_id']) . ')">Reject</button>';
                echo '        <button class="order-button" onclick="updatesellerApproved(' . htmlspecialchars($row['order_id']) . ')">Approve</button>';
                echo '    </div>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }
    
            if ($row['buyer_status'] == 'cancelled' && $row['seller_status'] == 'pending') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Buyer: @' . htmlspecialchars($row['buyer_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['buyer_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['buyer_street']) . ' ' . htmlspecialchars($row['buyer_barangay']) . ', ' . htmlspecialchars($row['buyer_city']) . ', ' . htmlspecialchars($row['buyer_province']) . ', ' . htmlspecialchars($row['buyer_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '    <div class="order-button-bar">';
                echo '        <p class="order-status">'. htmlspecialchars($row['ordered_at']) . '</p>';
                echo '        <p class="order-cancelled">Cancelled</p>';
                echo '    </div>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }
    
            if ($row['buyer_status'] == 'confirmed' && $row['seller_status'] == 'rejected') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Buyer: @' . htmlspecialchars($row['buyer_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['buyer_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['buyer_street']) . ' ' . htmlspecialchars($row['buyer_barangay']) . ', ' . htmlspecialchars($row['buyer_city']) . ', ' . htmlspecialchars($row['buyer_province']) . ', ' . htmlspecialchars($row['buyer_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '    <div class="order-button-bar">';
                echo '        <p class="order-status">'. htmlspecialchars($row['ordered_at']) . '</p>';
                echo '        <p class="order-cancelled">Rejected</p>';
                echo '    </div>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }
    
            if ($row['buyer_status'] == 'confirmed' && $row['seller_status'] == 'approved' && $row['order_status'] == 'pending') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Buyer: @' . htmlspecialchars($row['buyer_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['buyer_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['buyer_street']) . ' ' . htmlspecialchars($row['buyer_barangay']) . ', ' . htmlspecialchars($row['buyer_city']) . ', ' . htmlspecialchars($row['buyer_province']) . ', ' . htmlspecialchars($row['buyer_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '    <div class="order-button-bar">';
                echo '        <form onsubmit="updateMorderStatus(event)">';
                echo '            <input type="hidden" name="order_id" value="' . htmlspecialchars($row['order_id']) . '">';
                echo '            <select name="order_status" class="order-status-select">';
                echo '                <option value="pending"' . ($row['order_status'] == 'pending' ? ' selected' : '') . '>Pending</option>';
                echo '                <option value="preparing"' . ($row['order_status'] == 'preparing' ? ' selected' : '') . '>Preparing</option>';
                echo '                <option value="delivering"' . ($row['order_status'] == 'delivering' ? ' selected' : '') . '>Delivering</option>';
                echo '            </select>';
                echo '            <button class="order-button" type="submit">Update</button>';
                echo '             <p class="order-status-middle">Pending</p>';
                echo '        </form>';
                echo '    </div>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }
    
    
            if ($row['buyer_status'] == 'confirmed' && $row['seller_status'] == 'approved' && $row['order_status'] == 'preparing') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Buyer: @' . htmlspecialchars($row['buyer_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['buyer_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['buyer_street']) . ' ' . htmlspecialchars($row['buyer_barangay']) . ', ' . htmlspecialchars($row['buyer_city']) . ', ' . htmlspecialchars($row['buyer_province']) . ', ' . htmlspecialchars($row['buyer_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '    <div class="order-button-bar">';
                echo '        <form onsubmit="updateMorderStatus(event)">';
                echo '            <input type="hidden" name="order_id" value="' . htmlspecialchars($row['order_id']) . '">';
                echo '            <select name="order_status" class="order-status-select">';
                echo '                <option value="pending"' . ($row['order_status'] == 'pending' ? ' selected' : '') . '>Pending</option>';
                echo '                <option value="preparing"' . ($row['order_status'] == 'preparing' ? ' selected' : '') . '>Preparing</option>';
                echo '                <option value="delivering"' . ($row['order_status'] == 'delivering' ? ' selected' : '') . '>Delivering</option>';
                echo '            </select>';
                echo '            <button class="order-button" type="submit">Update</button>';
                echo '             <p class="order-status-middle">Preparing</p>';
                echo '        </form>';
                echo '    </div>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }
    
            if ($row['buyer_status'] == 'confirmed' && $row['seller_status'] == 'approved' && $row['order_status'] == 'delivering') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Buyer: @' . htmlspecialchars($row['buyer_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['buyer_phone']) . '</p>';
                echo '                <p>Location:' . htmlspecialchars($row['buyer_street']) . ' ' . htmlspecialchars($row['buyer_barangay']) . ', ' . htmlspecialchars($row['buyer_city']) . ', ' . htmlspecialchars($row['buyer_province']) . ', ' . htmlspecialchars($row['buyer_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '    <div class="order-button-bar">';
                echo '        <form onsubmit="updateMorderStatus(event)">';
                echo '            <input type="hidden" name="order_id" value="' . htmlspecialchars($row['order_id']) . '">';
                echo '            <select name="order_status" class="order-status-select">';
                echo '                <option value="pending"' . ($row['order_status'] == 'pending' ? ' selected' : '') . '>Pending</option>';
                echo '                <option value="preparing"' . ($row['order_status'] == 'preparing' ? ' selected' : '') . '>Preparing</option>';
                echo '                <option value="delivering"' . ($row['order_status'] == 'delivering' ? ' selected' : '') . '>Delivering</option>';
                echo '            </select>';
                echo '            <button class="order-button" type="submit">Update</button>';
                echo '             <p class="order-status-middle">Delivering</p>';
                echo '        </form>';
                echo '    </div>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }
            if ($row['buyer_status'] == 'confirmed' && $row['seller_status'] == 'approved' && $row['order_status'] == 'delivered') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Buyer: @' . htmlspecialchars($row['buyer_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['buyer_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['buyer_street']) . ' ' . htmlspecialchars($row['buyer_barangay']) . ', ' . htmlspecialchars($row['buyer_city']) . ', ' . htmlspecialchars($row['buyer_province']) . ', ' . htmlspecialchars($row['buyer_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '    <div class="order-button-bar">';
                echo '        <p class="order-status">'. htmlspecialchars($row['ordered_at']) . '</p>';
                echo '        <p class="order-cancelled">Delivered</p>';
                echo '    </div>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }
        }
    } else {
        echo '<center>No orders found.</center>';
    }
    

    mysqli_close($conn);
}
?>