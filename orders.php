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
    <link rel="stylesheet" href='css/comment.css'> 
    <link rel="stylesheet" href='css/marketplace.css'> 
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
            <a href="orders.php" class="headtitle-order">
                <p>Order Details</p>
            </a>
        </div>
        <div class="order-section">
        <div>
            <form class="comment-form" id="followingForm">
                    <input class="following-search-box" style="  padding-top: 1vw; padding-left: 2vw;padding-right: 2vw;" placeholder="Finding your orders???" id="search_order" name="search_order" />
            </form>
        </div>
            <!-- sample Orders here -->
            <div id="orders">
            <?php include 'backend/fetchorders.php'; ?>

            </div>
        </div>
    </div>

    <!-- review Product Modal -->
    <div id="review-product-modal" class="add-product-modal" onclick="closemyReviewProduct(event)">
    <div class="report-post-body reviewmodal" onclick="event.stopPropagation();">
        <div>
            <h2>Review <span style="color:#994700;">Product</span></h2> 
            <form id="reviewform">
                <div class="productform">
                    <input type="hidden" id="product_ids" name="product_ids" value="">
                    <textarea id="review_content" row=1 name="review_content" class="marketplace-search-box" placeholder="Share your thoughts..." required></textarea>
                    <select id="rating" name="rating" class="marketplace-search-box" required>
                        <option value="1">1 ⭐</option>
                        <option value="2">2 ⭐</option>
                        <option value="3">3 ⭐</option>
                        <option value="4">4 ⭐</option>
                        <option value="5">5 ⭐</option>
                    </select>
                    <button class="add-product-button" onclick="reviewProduct()" >Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- report Product Modal -->
<div id="report-product-modal" class="add-product-modal" onclick="closeReportProduct(event)">
    <div class="report-product-body reportmodal" onclick="event.stopPropagation();">
        <div>
            <h2>Product <span style="color:#994700;">Report</span></h2> 
            <form id="reportform" action="backend/reportproduct.php" method="POST">
                <div class="productform">
                    <input type="hidden" id="reported_user_id" name="reported_user_id" value="">
                    <input type="hidden" id="product_id" name="product_id" value="">
                    <input type="hidden" id="reporter_username" name="reporter_username" value="">
                    <input type="hidden" id="reported_username" name="reported_username" value="">
                    <input type="hidden" id="report_type" name="report_type" value="Product">
                    <select id="report_issue" name="report_issue" class="marketplace-search-box" required>
                        <option value="inappropriate_content">Inappropriate Content</option>
                        <option value="Harrasment">Harrasment</option>
                        <option value="spam">Spam</option>
                        <option value="scam">Scam</option>
                        <option value="misleading_information">Misleading Information</option>
                        <option value="poser">poser</option>
                    </select>
                    <input id="report_description" name="report_description" class="marketplace-search-box" placeholder="Tell us your complain..." maxlength="25" required>

                    <button class="add-product-button" type="submit" >Report Product</button>
                </div>
            </form>
            
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
<script src="js/order.js"></script>
<script src="js/marketplace.js"></script>

<body>

</body>

</html>