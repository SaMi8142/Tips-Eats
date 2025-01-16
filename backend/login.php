<?php
session_start(); 

include 'connection.php';  

if (isset($_POST['email']) && isset($_POST['password'])) {
    
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];  

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            // Store user details in the session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['middle_name'] = $user['middle_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['suffix'] = $user['suffix'];
            $_SESSION['profile_pic'] = $user['profile_pic'];
            $_SESSION['email'] = $user['email'];  
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['birthday'] = $user['birthday'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['street'] = $user['street'];
            $_SESSION['region'] = $user['region'];
            $_SESSION['province'] = $user['province'];
            $_SESSION['city'] = $user['city'];
            $_SESSION['barangay'] = $user['barangay'];
            $_SESSION['postal_code'] = $user['postal_code'];
            $_SESSION['username'] = $user['username'];

            // Redirect based on is_admin value
            if ($user['is_admin'] == 1) {
                header("Location: ../admin.html");
            } else {
                header("Location: ../home.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid email or password.'); window.location.href = '../index.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href = '../index.php';</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Please fill in both fields.'); window.location.href = '../index.php';</script>";
}
?>
