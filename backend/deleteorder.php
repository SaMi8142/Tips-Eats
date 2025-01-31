<?php
// Database connection
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape special characters for SQL
    $order_id = $conn->real_escape_string($_POST['order_id']);

    // Delete order from the database
    $sql = "DELETE FROM Orders WHERE order_id = '$order_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Order deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>