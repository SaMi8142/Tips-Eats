<?php
include 'connection.php'; // Ensure this file contains your database connection

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (isset($_POST['update_product_id'], $_POST['update_title'], $_POST['update_content'], $_POST['update_price'])) {
        $product_id = intval($_POST['update_product_id']);
        $product_title = trim($_POST['update_title']);
        $product_content = trim($_POST['update_content']);
        $product_price = floatval($_POST['update_price']);

        // Prevent empty values
        if (empty($product_title) || empty($product_content) || $product_price <= 0) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        // Update product query
        $sql = "UPDATE Products SET product_title = ?, product_content = ?, price = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssdi", $product_title, $product_content, $product_price, $product_id);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Product updated successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to update product.'];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Database error.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Invalid request.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

$conn->close();
echo json_encode($response);
?>
