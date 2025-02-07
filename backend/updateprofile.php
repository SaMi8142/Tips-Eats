<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_id = $_SESSION['user_id'];

    // Retrieve form data
    $first_name = $_POST['profile_first_name'];
    $middle_name = $_POST['profile_middle_name'];
    $last_name = $_POST['profile_last_name'];

    // Update the user profile in the database
    $query = "UPDATE users SET first_name=?, middle_name=?, last_name=? WHERE user_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $first_name, $middle_name, $last_name, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database update failed"]);
    }

    $stmt->close();
    $conn->close();
}
?>
