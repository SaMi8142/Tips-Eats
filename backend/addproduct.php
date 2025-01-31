<?php
// Database connection
include 'connection.php';

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$product_title = mysqli_real_escape_string($conn, $_POST['product_title']);
$product_content = mysqli_real_escape_string($conn, $_POST['product_content']);
$product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
$product_pic = $_FILES['product_pic'];
$date = date("Y-m-d H:i:s");

// Directory where the image will be saved
$target_dir = "productpic/";
// Add a timestamp to the filename to make it unique
$timestamp = time();
$target_file = $target_dir . $timestamp . '_' . basename($product_pic["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
$check = getimagesize($product_pic["tmp_name"]);
if($check === false) {
    exit;
}

// Check file size (5MB max)
if ($product_pic["size"] > 5000000) {
    exit;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    exit;
}

// Move the uploaded file to the target directory
if (!move_uploaded_file($product_pic["tmp_name"], $target_file)) {
    exit;
}

// Insert product into database
$sql = "INSERT INTO Products (user_id, product_title, product_content, product_pic, price, date) VALUES ('$user_id', '$product_title', '$product_content', '$target_file', '$product_price', '$date')";
if (mysqli_query($conn, $sql)) {
    header("Location: ../marketplace.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>