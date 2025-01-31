<?php

// Database connection
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape special characters for SQL
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['order_status']);

    // Update order_status in the database
    $sql = "UPDATE Orders SET order_status = '$status' WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Order status updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>