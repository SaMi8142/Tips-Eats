<?php
// Database connection
include 'connection.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape special characters for SQL
    $product_id = $conn->real_escape_string($_POST['product_id']);
    $seller_id = $conn->real_escape_string($_POST['seller_id']);
    $buyer_id = $_SESSION['user_id']; // Use the logged-in user ID

    // Fetch product details
    $product_sql = "SELECT product_title, price FROM Products WHERE product_id = '$product_id' AND user_id = '$seller_id'";
    $product_result = $conn->query($product_sql);
    if ($product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $order_title = $conn->real_escape_string($product_row['product_title']);
        $order_price = $product_row['price'];
    } else {
        echo "Product not found.";
        exit;
    }

    // Fetch buyer details
    $buyer_sql = "SELECT city AS buyer_city, phone AS buyer_number FROM Users WHERE user_id = '$buyer_id'";
    $buyer_result = $conn->query($buyer_sql);
    if ($buyer_result->num_rows > 0) {
        $buyer_row = $buyer_result->fetch_assoc();
        $buyer_city = $buyer_row['buyer_city'];
        $buyer_number = $buyer_row['buyer_number'];
    } else {
        echo "Buyer not found.";
        exit;
    }

    // Fetch seller details
    $seller_sql = "SELECT city AS seller_city FROM Users WHERE user_id = '$seller_id'";
    $seller_result = $conn->query($seller_sql);
    if ($seller_result->num_rows > 0) {
        $seller_row = $seller_result->fetch_assoc();
        $seller_city = $seller_row['seller_city'];
    } else {
        echo "Seller not found.";
        exit;
    }

    $order_quantity = $conn->real_escape_string($_POST['order_quantity']);
    $order_finalprice = $order_price * $order_quantity;
    $order_status = "pending";
    $buyer_status = "pending";
    $seller_status = "pending";
    $ordered_at = date("Y-m-d H:i:s");

    // Insert order into database
    $sql = "INSERT INTO Orders (product_id, seller_id, buyer_id, order_title, order_price, order_quantity, order_finalprice, order_status, buyer_city, buyer_number, buyer_status, seller_city, seller_status, ordered_at) 
            VALUES ('$product_id', '$seller_id', '$buyer_id', '$order_title', '$order_price', '$order_quantity', '$order_finalprice', '$order_status', '$buyer_city', '$buyer_number', '$buyer_status', '$seller_city', '$seller_status', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "Order placed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>