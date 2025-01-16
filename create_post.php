<?php
session_start();
include 'backend/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    $image = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $image_name = basename($_FILES['image']['name']);
        $image_path = $upload_dir . $image_name;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = $image_name; // Store only the image name
        }
    }

    // Insert post into the database
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$user_id, $content, $image]);

    // Redirect to the home page
    header('Location: home.php');
    exit();
}
?>
