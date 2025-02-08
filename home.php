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
    <link rel="stylesheet" href='css/main.css'>
    <link rel="stylesheet" href='css/comment.css'> 
    <link rel="stylesheet" href='css/marketplace.css'> 
    <title>Main</title>
</head>
<body>
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
    <h3><?php echo $first_name . ' ' . $last_name; ?></h3>
    <p>@<?php echo $username; ?></p>
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
            <a href="home.php" class="headtitle-newsfeed underline">
                <p>News Feed</p>
            </a>
            <a href="fhome.php" class="headtitle-follow">
             <p>Following</p>
            </a>
        </div>


        <!-- Sample Post here! -->

       <div class="post-section">
             <!-- Post Form here! -->
        <form action="backend/post.php" method="post" enctype="multipart/form-data">
        <div class="postform">
            <div class="post-card">
                <div class="post-card-pic">
                    <img src="<?= $profile_img ?>" alt="profile" class="profile">
                </div>

                <input type="hidden" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
                <input type="hidden" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
                <input type="hidden" id="username" name="username" value="<?php echo $_SESSION['username'] ?>">
                <input type="hidden" id="profile_pic" name="profile_pic" value="<?= $profile_pic ?>">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                <textarea class="input-box" rows="1" placeholder="Share your recipes and ideas.." id="post_content" name="post_content" required></textarea>
            </div>
            <div class="post-button">
                <div class="post-button-left">
                    <label for="post_pic">Image</label>
                    <input type="file" id="post_pic" name="post_pic" accept="image/*" required>
                </div>
                <button type="submit" class="post-button-right">
                    <p>Post</p>
                </button>
            </div>
        </div>
    </form>
    <div id='post'>
        <?php include 'backend/fetchposts.php'; ?>
</div>    
</div>
    </div>  

<!-- Comment Modal -->
<div id="comment-modal" class="comment-modal" onclick="closeComment(event)">
    <div class="comment-body" onclick="event.stopPropagation();">
        <div>
            <form class="comment-form" id="commentForm" onsubmit="submitComment(event)">
                <div class="post-card">
                    <div class="post-card-pic">
                        <img src="<?= $profile_img ?>" alt="profile" class="profile">
                    </div>
                    <input type="hidden" id="first_name" name="first_name" value="<?= $first_name ?>">
                    <input type="hidden" id="last_name" name="last_name" value="<?= $last_name ?>">
                    <input type="hidden" id="username" name="username" value="<?= $_SESSION['username']; ?>">
                    <input type="hidden" id="profile_pic" name="profile_pic" value="<?= $profile_pic?>">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" id="post_id" name="post_id" value="">
                    <textarea class="comment-box" rows="1" style="resize: none;" placeholder="Share your thoughts..." id="comment_content" name="comment_content" required></textarea>
                    <button class="comment-button" type="submit">Submit</button>
                </div>
            </form>
        </div>

        <!-- Sample comments here -->
        <div class="comment-section">
            <div class="post-container">
                <div class="post-container-profile">
                    <div>
                        <img src="img/Avatar Image.png" alt="profile" class="profile">
                    </div>
                    <div class="post-container-content">
                        <h3>Allen Siddayao · 4 hrs ago</h3>
                        <p>@allenibba123</p>
                    </div>
                    <button class="comment-like">Like</button>
                    <span class="comment-like-count">0</span>
                </div>
                <div class="post-container-body">
                    <pre>Hey foodies! 🌟 I just whipped up the fluffiest pancakes ever, and I couldn't wait to share the recipe with you all! Perfect for a cozy breakfast or brunch. Here's how you can make them too:</pre>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- report Post Modal -->
<div id="report-post-modal" class="add-product-modal" onclick="closeReportPost(event)">
    <div class="report-post-body reportmodal" onclick="event.stopPropagation();">
        <div>
            <h2>Post <span style="color:#994700;">Report</span></h2> 
            <form id="reportform">
                <div class="productform">
                    <input type="hidden" id="reported_user_id" name="reported_user_id" value="">
                    <input type="hidden" id="product_id" name="product_id" value="">
                    <input type="hidden" id="reporter_username" name="reporter_username" value="">
                    <input type="hidden" id="reported_username" name="reported_username" value="">
                    <input type="hidden" id="report_type" name="report_type" value="Post">
                    <select id="report_issue" name="report_issue" class="marketplace-search-box" required>
                        <option value="inappropriate_content">Inappropriate Content</option>
                        <option value="Harrasment">Harrasment</option>
                        <option value="spam">Spam</option>
                        <option value="scam">Scam</option>
                        <option value="misleading_information">Misleading Information</option>
                        <option value="poser">poser</option>
                    </select>
                    <input id="report_description" name="report_description" class="marketplace-search-box" placeholder="Tell us your complain..." maxlength="25" required>
                    <button class="add-product-button" onclick="reportPost()" >Report Post</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<!-- Update Post Modal -->
<div id="update-post-modal" class="add-product-modal" onclick="closeUpdatePost(event)">
    <div class="update-post-body updatemodal" onclick="event.stopPropagation();">
        <div>
            <h2>Post <span style="color:#994700;">Update</span></h2> 
            <form id="updateform">
                <div class="productform">
                    <input type="hidden" id="update_post_id" name="update_post_id" value="">
                    <textarea class="marketplace-search-box" rows="4" placeholder="Contents" id="update_content" name="update_content" value="" required></textarea>
                    <button class="add-product-button" onclick="updatePost()" >Update Post</button>
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
<script src="js/followingpost.js"></script>
<script src="js/marketplace.js"></script>
</body>

</html>

