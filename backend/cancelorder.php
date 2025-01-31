<?php
// Database connection
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape special characters for SQL
    $order_id = $conn->real_escape_string($_POST['order_id']);

    // Update buyer_status to 'cancelled' in the database
    $sql = "UPDATE Orders SET buyer_status = 'cancelled' WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $sql)) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>