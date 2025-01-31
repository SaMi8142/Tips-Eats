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
$sql = "SELECT o.order_id, o.product_id, o.order_title, o.order_price, o.order_quantity, o.order_finalprice, o.order_status, o.buyer_city, o.buyer_number, o.seller_city, o.ordered_at, o.buyer_status, o.seller_status, p.product_pic, p.product_title, p.price, u.first_name, u.last_name, u.username AS seller_username, u.profile_pic, u.region AS seller_region, u.province AS seller_province, u.city AS seller_city, u.barangay AS seller_barangay, u.phone AS seller_phone,
               CASE 
                   WHEN o.buyer_status = 'confirmed' AND o.seller_status = 'pending' THEN 1 
                   WHEN o.seller_status = 'pending' AND o.buyer_status = 'pending' THEN 2 
                   WHEN o.seller_status = 'rejected' AND o.buyer_status = 'confirmed' THEN 3 
                   WHEN o.buyer_status = 'cancelled' THEN 4 
                   ELSE 5 
               END AS order_priority
        FROM Orders o 
        JOIN Products p ON o.product_id = p.product_id 
        JOIN Users u ON o.seller_id = u.user_id 
        WHERE o.buyer_id = '$logged_in_user_id' 
        AND (o.order_title LIKE '%$query%' 
             OR o.order_id LIKE '%$query%' 
             OR u.username LIKE '%$query%' 
             OR u.city LIKE '%$query%' 
             OR o.ordered_at LIKE '%$query%' 
             OR u.province LIKE '%$query%' 
             OR u.region LIKE '%$query%' 
             OR o.order_status LIKE '%$query%' 
             OR o.seller_status LIKE '%$query%' 
             OR o.buyer_status LIKE '%$query%')
        ORDER BY order_priority, o.ordered_at DESC";
$result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // Additional conditions
            if ($row['buyer_status'] == 'pending' && $row['seller_status'] == 'pending') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <form onsubmit="updateOrder(event)">';
                echo '            <input type="hidden" name="order_id" value="' . htmlspecialchars($row['order_id']) . '">';
                echo '            <input type="hidden" name="order_price" value="' . htmlspecialchars($row['order_price']) . '">';
                echo '            <input type="hidden" name="order_status" value="pending">';
                echo '            <input type="hidden" name="seller_status" value="pending">';
                echo '            <input type="hidden" name="buyer_status" value="confirmed">';
                echo '            <div class="counter">';
                echo '                <input type="number" name="order_quantity" value="' . htmlspecialchars($row['order_quantity']) . '" min="1" step="1">';
                echo '            </div>';
                echo '            <button class="order-button" type="submit">Confirm Order</button>';
                echo '        </form>';
                echo '        <button class="order-delete-button" onclick="deleteOrder(' . htmlspecialchars($row['order_id']) . ')">Delete Order</button>';
                echo '    </div>';
                echo '    </div>';
                echo '</div>';
            }

            if ($row['buyer_status'] == 'confirmed' && $row['seller_status'] == 'pending') {
                echo '<div class="order-card">';
                echo '    <div class="order-card-header">';
                echo '        <div class="order-card-profile">';
                echo '            <div>';
                echo '                <img src="backend/' . htmlspecialchars($row['product_pic']) . '" alt="profile" class="product-pic">';
                echo '            </div>';
                echo '            <div class="order-card-content">';
                echo '                <h3>' . htmlspecialchars($row['order_title']) . '</h3>';
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <p class="order-status">Under-Review</p>';
                echo '        <button class="order-button" onclick="cancelOrder(' . htmlspecialchars($row['order_id']) . ')">Cancel Order</button>';
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
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <p class="order-status">'. htmlspecialchars($row['ordered_at']) . '</p>';
                echo '        <p class="order-cancelled">Cancelled</p>';
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
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <p class="order-status">'. htmlspecialchars($row['ordered_at']) . '</p>';
                echo '        <p class="order-cancelled">Rejected</p>';
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
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <p class="order-status">Pending</p>';
                echo '        <p class="order-cancelled">Approved</p>';
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
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <p class="order-status">Preparing</p>';
                echo '        <p class="order-cancelled">Approved</p>';
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
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <p class="order-status">Delivering</p>';
                echo '        <button class="order-button" onclick="orderDelivered(' . htmlspecialchars($row['order_id']) .')">Order Delivered</button>';
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
                echo '                <p>Seller: @' . htmlspecialchars($row['seller_username']) . '</p>';
                echo '                <p>Contact: ' . htmlspecialchars($row['seller_phone']) . '</p>';
                echo '                <p>Location: ' . htmlspecialchars($row['seller_barangay']) . ', ' . htmlspecialchars($row['seller_city']) . ', ' . htmlspecialchars($row['seller_province']) . ', ' . htmlspecialchars($row['seller_region']) . '</p>';
                echo '                <h4 class="product-price">P ' . htmlspecialchars($row['order_finalprice']) . '</h4>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="order-form">';
                echo '        <p class="order-status">Delivered</p>';
                echo '        <button class="order-button" onclick="orderDelivered(' . htmlspecialchars($row['order_id']) . ')">Review</button>';
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