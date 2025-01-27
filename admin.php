<?php
session_start();  // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch user data from session
    $user_id = $_SESSION['user_id'];
    $first_name = $_SESSION['first_name'];
    $middle_name = $_SESSION['middle_name'];
    $last_name = $_SESSION['last_name'];
    $suffix = $_SESSION['suffix'];
    $profile_pic = $_SESSION['profile_pic'];
    $username = $_SESSION['username']; 
    $email = $_SESSION['email'];
    $gender = $_SESSION['gender'];
    $birthday = $_SESSION['birthday'];
    $phone = $_SESSION['phone'];
    $street = $_SESSION['street'];
    $region = $_SESSION['region'];
    $province = $_SESSION['province'];
    $city = $_SESSION['city'];
    $barangay = $_SESSION['barangay'];
    $postal_code = $_SESSION['postal_code'];

    //for the directory of the profile picture
    $profile_img = "backend/" . $profile_pic;

} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="js/admin.js"></script>
</head>
<body>
    <div class="main-container">
        <div class="side-navbar">
            <div class="top-sidenavbar">
                <div id="title-container">
                    <p>Tips&</p><p style="color: #994700;">Eats<sub style="font-size: 0.6em;">Admin</sub></p>
                </div>
                <div id="navbuttons-container">
                    <div id="title-navbuttons">
                        <p>Main</p>
                    </div>
                    <div id="navbuttons">
                        <div id="user-reports" onclick="window.location.href='admin.php'">
                            <img src="img/message-square-warning.png" alt="">
                            <p>User Reports</p>
                        </div>
                        <div id="account-verif" onclick="window.location.href='AccountVerification.php'">
                            <img src="img/badge-check.png" alt="">
                            <p>Account Verifications</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-sidenavbar">
                <div class="profile-container">
                    <div class="admin-pic">
                        <img src="img/Avatar Image.png" alt="" width="35px" style="border-radius: 50%; border: 2px solid rgb(19, 218, 19)">
                    </div>
                    <div class="admin-info">
                        <p><strong><?php echo $first_name . ' ' . $last_name; ?></strong><br>Administrator</p>
                    </div>
                    <div class="logoutbtn">
                        <div class="popup_logout" id="popuplogout"> 
                            <a href="index.php">Log Out</a> 
                        </div>
                        <img src="img/ellipsis.png" alt="" onclick="popup_logout()" style="cursor: pointer;">
                    </div>
                </div>
            </div>
        </div>
        <div class="info-page">
            <div class="title-search">
                <div id="title">
                    <div>
                        <p>Manage&nbsp;</p><p id="title-text">User Reports</p>
                    </div>
                </div>
                <div id="search">
                    <input type="text" name="" id="" placeholder="Search user...">
                </div>
            </div>
            <div class="table">
                <table>
                    <thead>
                        <td>User ID</td>
                        <td>Reporter</td>
                        <td>Reported</td>
                        <td>Report Type</td>
                        <td>Report Issue</td>
                        <td>Report Description</td>
                        <td>Action</td>
                    </thead>
                    <tr>
                        <td>12162</td>
                        <td>@Lamuel</td>
                        <td>@Kian</td>
                        <td>Post</td>
                        <td>
                            <div class="document-column"><p>Spam</p></div>
                        </td>
                        <td>Impersonation</td>
                        <td>
                            <div class="action-column"><button id="check-btn"><img src="img/circle-check.png" alt=""></button><button id="x-btn"><img src="img/circle-x.png" alt=""></button></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 