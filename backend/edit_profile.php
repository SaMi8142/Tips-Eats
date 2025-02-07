<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input values
    $user_id = $_POST['user_id'];
    $first_name = $_POST['profile_first_name'];
    $middle_name = $_POST['profile_middle_name'];
    $last_name = $_POST['profile_last_name'];
    $suffix = $_POST['profile_suffix'];
    $username = $_POST['profile_username'];
    $birthday = $_POST['profile_birthday'];
    $phone = $_POST['profile_phone'];
    $gender = $_POST['profile_gender'];
    $street = $_POST['profile_street'];
    $barangay = $_POST['profile_barangay'];
    $postal_code = $_POST['profile_postal_code'];
    $region = $_POST['profile_region'];
    $province = $_POST['profile_province'];
    $city = $_POST['profile_city'];

    // Password inputs
    $old_pass = $_POST['profile_oldpass'] ?? "";
    $new_pass = $_POST['profile_newpass'] ?? "";
    $confirm_pass = $_POST['profile_confirmpass'] ?? "";

    // Handle profile picture upload
    if (!empty($_FILES['profile_profile_pic']['name'])) {
        $upload_dir = "../backend/profilepic/";  // Directory to store profile pictures
        $original_filename = basename($_FILES['profile_profile_pic']['name']);
        $extension = pathinfo($original_filename, PATHINFO_EXTENSION);
        $timestamp = time(); // Unique timestamp
        $new_filename = "profile_" . $user_id . "_" . $timestamp . "." . $extension;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['profile_profile_pic']['tmp_name'], $target_file)) {
            $profile_pic_path = "profilepic/" . $new_filename;
        } else {
            die("Error uploading profile picture.");
        }
    } else {
        $profile_pic_path = $_SESSION['profile_pic']; // Keep existing profile picture
    }

    // Password validation and update
    $hashed_new_password = null;
    if (!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass)) {
        if ($new_pass !== $confirm_pass) {
            die("Error: New passwords do not match.");
        }

        // Verify old password
        $query = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $current_password = $row['password'];

        if (password_verify($old_pass, $current_password)) {
            $hashed_new_password = password_hash($new_pass, PASSWORD_DEFAULT);
        } else {
            die("Error: Old password is incorrect.");
        }
        $stmt->close();
    }

    // Update query for user profile
    if ($hashed_new_password) {
        $query = "UPDATE users SET first_name = ?, middle_name = ?, last_name = ?, suffix = ?, 
                  username = ?, birthday = ?, phone = ?, gender = ?, street = ?, barangay = ?, 
                  postal_code = ?, region = ?, province = ?, city = ?, profile_pic = ?, password = ? 
                  WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssssssssssi", $first_name, $middle_name, $last_name, $suffix, 
                          $username, $birthday, $phone, $gender, $street, $barangay, 
                          $postal_code, $region, $province, $city, $profile_pic_path, $hashed_new_password, $user_id);
    } else {
        $query = "UPDATE users SET first_name = ?, middle_name = ?, last_name = ?, suffix = ?, 
                  username = ?, birthday = ?, phone = ?, gender = ?, street = ?, barangay = ?, 
                  postal_code = ?, region = ?, province = ?, city = ?, profile_pic = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssssssssi", $first_name, $middle_name, $last_name, $suffix, 
                          $username, $birthday, $phone, $gender, $street, $barangay, 
                          $postal_code, $region, $province, $city, $profile_pic_path, $user_id);
    }

    if ($stmt->execute()) {
        // Update related tables with new data
        $profile_pic_sql = !empty($profile_pic_path) ? ", profile_pic = '$profile_pic_path'" : "";

        // Update related tables with new data, excluding 'date' field
        $query_posts = "UPDATE Posts SET first_name = '$first_name', last_name = '$last_name', username = '$username' $profile_pic_sql WHERE user_id = $user_id";
        $query_comments = "UPDATE Comments SET first_name = '$first_name', last_name = '$last_name', username = '$username' $profile_pic_sql WHERE user_id = $user_id";
        $query_reviews = "UPDATE Reviews SET first_name = '$first_name', last_name = '$last_name', username = '$username' $profile_pic_sql WHERE user_id = $user_id";

        // Execute the updates for related tables
        $conn->query($query_posts);
        $conn->query($query_comments);
        $conn->query($query_reviews);


        // Update session variables
        $_SESSION['first_name'] = $first_name;
        $_SESSION['middle_name'] = $middle_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['suffix'] = $suffix;
        $_SESSION['username'] = $username;
        $_SESSION['birthday'] = $birthday;
        $_SESSION['phone'] = $phone;
        $_SESSION['gender'] = $gender;
        $_SESSION['street'] = $street;
        $_SESSION['barangay'] = $barangay;
        $_SESSION['postal_code'] = $postal_code;
        $_SESSION['region'] = $region;
        $_SESSION['province'] = $province;
        $_SESSION['city'] = $city;
        $_SESSION['profile_pic'] = $profile_pic_path;

        header("Location: ../profile.php?update=success&profile_pic=" . urlencode($profile_pic_path));
        exit();
    } else {
        header("Location: ../profile.php?update=error");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
