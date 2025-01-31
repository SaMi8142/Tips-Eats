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
                <a href="morders.php">Product Orders</a>
                <a href="mmarketplace.php">My Products</a>
                <a href="mhome.php">My Posts</a>
                <a href="index.php">Log Out</a>
            </div>
           
        </div>
    </div>

    <!-- Middle section here! -->
    <div class="middle-section">
        <div class="header headtitle">
            <a href="home.php" class="headtitle-newsfeed underline">
                <p>Products</p>
            </a>
            <a href="fhome.php" class="headtitle-follow">
             <p>CookMark</p>
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
                <textarea class="marketplace-search-box" rows="1" style="resize: none;" placeholder="Craving for something???" id="search_marketplace" name="search_marketplace" required></textarea>
            </div>
        </div>
    </form>
    <button class="add-product-button" onclick="openAddProduct()">Add product</button>
    <div id='product'>
        <!-- Products will be loaded here -->
        <?php include 'backend/fetchproducts.php'; ?>
    </div>
</div>
</div>

<!-- Add Product Modal -->
<div id="add-product-modal" class="add-product-modal" onclick="closeAddProduct(event)">
    <div class="add-product-body" onclick="event.stopPropagation();">
        <div>
            <h2>Create a <span style="color:#994700;">Product</span></h2> 
            <form action="backend/addproduct.php" method="post" enctype="multipart/form-data">
                <div class="productform">
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="text" class="marketplace-input-box" placeholder="Title" id="product_title" name="product_title" required/>
                    <div class="custom-file-input">
                        <label for="product_pic" class="custom-file-label">Choose File</label>
                        <input type="file" id="product_pic" name="product_pic" class="marketplace-file-box" accept="image/*" required>
                        <span id="file-name" class="file-name">No file chosen</span>
                    </div>                 
                    <textarea class="marketplace-search-box" rows="2" placeholder="Contents" id="product_content" name="product_content" required></textarea>
                    <input type="number" min="1" class="marketplace-input-box" id="product_price" name="product_price" placeholder="Price" required>
                    <button class="add-product-button" >Add product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- review Product Modal -->
<div id="review-product-modal" class="add-product-modal" onclick="closeReviewProduct(event)">
    <div class="add-product-body reviewmodal" onclick="event.stopPropagation();">
        <div>
            <h2>Product <span style="color:#994700;">Reviews</span></h2> 
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
            <div class="recommended-card">
                <div class="recommended-card-header ">
                    <div class="recommended-card-profile">
                        <div>
                            <img src="img/Avatar Image.png" alt="profile" class="profile"></img>
                        </div>
                        <div class="recommended-card-content">
                            <h3>Allen Siddayao</h3>
                            <p>@allenibba123</p>
                        </div>
                    </div>
                    <div class="recommended-card-body">
                        <p>Hey foodies! 🌟 I just whipped up the fluffiest pancakes ever, and I couldn't wait to share
                            the recipe with you all! Perfect for a cozy breakfast or brunch. Here's how you can make
                            them too:</p>
                    </div>
                    <div class="recommended-card-footer">
                        <a href>
                            <p>see more...</p>
                        </a>
                    </div>
                </div>

            </div>

            <div class="recommended-card">
                <div class="recommended-card-header ">
                    <div class="recommended-card-profile">
                        <div>
                            <img src="img/Avatar Image5.png" alt="profile" class="profile"></img>
                        </div>
                        <div class="recommended-card-content">
                            <h3>Eli Thompson</h3>
                            <p>@FoodieExplorerEli</p>
                        </div>
                    </div>
                    <div class="recommended-card-body">
                        <p>Hey everyone! 👋 I just whipped up the most indulgent Leche Flan, and I'm thrilled to share
                            the recipe with you all! Perfect for a sweet treat after dinner or a special occasion.
                            Here's how you can make it too:</p>
                    </div>
                    <div class="recommended-card-footer">
                        <a href>
                            <p>see more...</p>
                        </a>
                    </div>
                </div>

            </div>
            <div class="recommended-card">
                <div class="recommended-card-header ">
                    <div class="recommended-card-profile">
                        <div>
                            <img src="img/Avatar Image6.png" alt="profile" class="profile"></img>
                        </div>
                        <div class="recommended-card-content">
                            <h3>Hannah</h3>
                            <p>@HomeChefHannah</p>
                        </div>
                    </div>
                    <div class="recommended-card-body">
                        <p>Hey everyone! 🙌 I just baked the most decadent, fudgy brownies, and I can't wait to share
                            the recipe with you all! Perfect for a sweet treat any time of day. Here’s how you can make
                            them too:</p>
                    </div>
                    <div class="recommended-card-footer">
                        <a href>
                            <p>see more...</p>
                        </a>
                    </div>
                </div>

            </div>

            <div class="recommended-card">
                <div class="recommended-card-header ">
                    <div class="recommended-card-profile">
                        <div>
                            <img src="img/Avatar Image4.png" alt="profile" class="profile"></img>
                        </div>
                        <div class="recommended-card-content">
                            <h3>Austin Arthur</h3>
                            <p>@HealthyAustin</p>
                        </div>
                    </div>
                    <div class="recommended-card-body">
                        <p>Hey everyone! 👋 I just made the creamiest, most delightful homemade mac and cheese, and I'm
                            excited to share the recipe with you all! Perfect for a comforting dinner or a hearty side
                            dish. Here's how you can make it too:</p>
                    </div>
                    <div class="recommended-card-footer">
                        <a href>
                            <p>see more...</p>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>






<script src="js/main.js"></script>
<script src="js/marketplace.js"></script>
</body>

</html>

