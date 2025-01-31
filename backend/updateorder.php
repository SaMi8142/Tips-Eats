<?php
// Database connection
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required POST variables are set
    if (isset($_POST['order_id'], $_POST['order_price'], $_POST['order_quantity'], $_POST['buyer_status'])) {
        // Escape special characters for SQL
        $order_id = $conn->real_escape_string($_POST['order_id']);
        $order_price = $conn->real_escape_string($_POST['order_price']);
        $order_quantity = $conn->real_escape_string($_POST['order_quantity']);
        $buyer_status = $conn->real_escape_string($_POST['buyer_status']);

        // Convert order_price and order_quantity to numbers
        $order_price = floatval($order_price);
        $order_quantity = intval($order_quantity);

        // Calculate the final price
        $order_finalprice = $order_price * $order_quantity;

        // Update order in the database
        $sql = "UPDATE Orders SET 
                    order_price = '$order_price', 
                    order_quantity = '$order_quantity', 
                    order_finalprice = '$order_finalprice', 
                    buyer_status = '$buyer_status'
                WHERE order_id = '$order_id'";

        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Error: Missing required POST variables.";
    }
}
?>