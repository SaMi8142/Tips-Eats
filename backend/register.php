<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $suffix = $_POST['suffix'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $street = $_POST['street'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $postalCode = $_POST['postalCode'];
    $isAdmin = $_POST['is_admin'];

    // Check if email or username already exists
    $checkSql = "SELECT * FROM users WHERE email='$email' OR username='$username'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email or Username already in use. Please try again with a different one.'); window.history.back();</script>";
    } else {
        // Handle the file upload
        if (isset($_FILES['userpic']) && $_FILES['userpic']['error'] == 0) {
            $profilePic = 'profilepic/' . time() . '_' . basename($_FILES['userpic']['name']);
            
            if (!move_uploaded_file($_FILES['userpic']['tmp_name'], $profilePic)) {
                echo "Error occurred while uploading the file.";
                $profilePic = NULL;
            }
        } else {
            $profilePic = NULL;
        }

        // Insert user data into the database
        $sql = "INSERT INTO users (first_name, middle_name, last_name, suffix, profile_pic, username, gender, birthday, phone, email, password, street, region, province, city, barangay, postal_code, is_admin) 
                VALUES ('$firstName', '$middleName', '$lastName', '$suffix', '$profilePic', '$username', '$gender', '$birthday', '$phone', '$email', '$password', '$street', '$region', '$province', '$city', '$barangay', '$postalCode', '$isAdmin')";

        if ($conn->query($sql) === TRUE) {
            echo "<script> window.location.href = '../index.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>
