<?php
include 'connection.php';

// Check if product_id is set and is numeric
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Update the product status to 'dismissed'
    $update_sql = "UPDATE Products SET status = 'dismissed' WHERE product_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "Product status updated to dismissed successfully.";
    } else {
        echo "Error updating product status.";
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>
