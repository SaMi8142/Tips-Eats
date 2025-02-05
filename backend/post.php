<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape special characters for SQL
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $post_content = $conn->real_escape_string($_POST['post_content']);
    $profile_pic = $conn->real_escape_string($_POST['profile_pic']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $username = $conn->real_escape_string($_POST['username']);

    // Handle file upload
    if (isset($_FILES['post_pic']) && $_FILES['post_pic']['error'] == 0) {
        $target_dir = "postpic/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $postPic = $target_dir . time() . '_' . basename($_FILES['post_pic']['name']);

        // Check if the file is uploaded successfully
        if (move_uploaded_file($_FILES['post_pic']['tmp_name'], $postPic)) {
            echo "The file ". basename($_FILES["post_pic"]["name"]). " has been uploaded.";
        } else {
            echo "Error occurred while uploading the file.";
            $postPic = NULL; // Set to NULL if upload fails
        }
    } else {
        $postPic = NULL; // No file uploaded
    }

    // Insert data into database
    $sql = "INSERT INTO Posts (user_id, post_pic, post_content, profile_pic, first_name, last_name, username, date)
            VALUES ('$user_id', '$postPic', '$post_content', '$profile_pic', '$first_name', '$last_name', '$username', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Redirect to home.php
        header("Location: ../home.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
