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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>Main</title>
</head>
<div class="container">

    <!--Left Section -->

    <div class="left-section">

        <div class="header">
            <h3 class="title">Tips&<span class="brown">Eats</span></h3>
        </div>

        <div class="navbar">
            <a href="home.php">
                <p>Home</p>
            </a>
            <a href="following.php">
                <p>Following</p>
            </a>
            <a href="marketplace.php">
                <p>MarketPlace</p>
            </a>
            <a href="orders.php">
                <p>My Orders</p>
            </a>
        </div>

        <div class="profiletag">
            <div class="profiletag-pic">
                <img src="<?= $profile_img ?>" alt="profile" class="profile"></img>
            </div>
            <div class="profiletag-content">
                <h3>
                    <?php echo $first_name . ' ' . $last_name; ?>
                </h3>
                <p>@
                    <?php echo $username; ?>
                </p>
            </div>

            <button class="profiletag-button" onclick="popup_logout()">···</button>
            <div class="dropdown-content" id="dropdown-content">
            <?php include 'backend/checkdropdown.php'; ?>          
            </div>
        </div>
    </div>

    <!-- Middle section here! -->
    <div class="middle-section">
        <div class="header headtitle">
        <h3 class="nav-logo">T&<span style="color: #994700;">Es</span></h3>
        <button class="nav-button" onclick="nav_logout()">···</button>
            <div class="navdown-content" id="navdown-content"> 
            <?php include 'backend/checknavdown.php'; ?>
            </div>
            <a href="morders.php" class="headtitle-order">
                <p>Product Order Details</p>
            </a>
        </div>
        <div class="order-section">
        <div>
            <form class="comment-form" id="followingForm">
                <input class="following-search-box" placeholder="Finding your orders???" id="search_morder" name="search_morder" />
            </form>
        </div>
            <!-- sample Orders here -->
            <div id="orders">
            <?php include 'backend/fetchmorders.php'; ?>

            </div>
        </div>
    </div>



    <!-- Right Section -->

    <div class="right-section">
        <div class="header ">
            <p class="headtitle-recommended">Recommended for you</p>
        </div>
        <!-- sample recommend here -->
        <div class="recommended">
        <?php include 'backend/recommendation.php'; ?>

        </div>
    </div>
</div>
<script src="js/main.js"></script>
<script src="js/morder.js"></script>

<body>

</body>

</html>