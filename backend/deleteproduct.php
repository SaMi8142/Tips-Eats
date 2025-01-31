<?php
include 'connection.php';

// Check if product_id is set and is numeric
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Delete the product from the Products table
    $delete_sql = "DELETE FROM Products WHERE product_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting product.";
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>