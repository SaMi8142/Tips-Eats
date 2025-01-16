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
            <a href="">
                <p>Friends</p>
            </a>
            <a href="following.php">
                <p>Following</p>
            </a>
            <a href="order.php">
                <p>Marketplace</p>
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

            <button class="profiletag-button">···</button>
            <div class="dropdown-content"> <a href="index.php">Log Out</a> </div>
        </div>
    </div>

    <!-- Middle section here! -->
    <div class="middle-section">
        <div class="header headtitle">
            <a href="order.php" class="headtitle-order">
                <p>Order Details</p>
            </a>
        </div>
        <div class="order-section">
            <!-- sample Orders here -->
            <div class="order-card">
                <div class="order-card-header">
                    <div class="order-card-profile">
                        <div>
                            <img src="img/pexels-ash-craig-122861-376464.jpg" alt="profile" class="product-pic"></img>
                        </div>
                    
                        <div class="order-card-content">
                            <h3>Fluffy Pancake Delight!</h3>
                            <p>Estimated Delivery Time</p>
                            <p>2 min</p>
                            <h4 class="product-price">P 110</h4>
                        </div>
                        </div>
                        <form class="order-form">
                            <div class="counter">
                                <input type="number" value="1" min="0">
                              </div>
                              <button class="order-button">Confirm Order</button>
                        </form>
                </div>
                </div>

                <div class="order-card">
                    <div class="order-card-header">
                        <div class="order-card-profile">
                            <div>
                                <img src="img/Leche-Flan-with-Cream-Cheese-7.jpg" alt="profile" class="product-pic"></img>
                            </div>
                        
                            <div class="order-card-content">
                                <h3>Fiesta De Leche!</h3>
                                <p>Estimated Delivery Time</p>
                                <p>40 min</p>
                                <h4 class="product-price">P 250</h4>
                            </div>
                            </div>
                            <form class="order-form">
                                <div class="counter">
                                    <input type="number" value="1" min="0">
                                  </div>
                                  <button class="order-button">Confirm Order</button>
                            </form>
                    </div>
                    </div>

                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-profile">
                                <div>
                                    <img src="img/tini-mac-cheese-4894w.jpg" alt="profile" class="product-pic"></img>
                                </div>
                            
                                <div class="order-card-content">
                                    <h3>Mac and Cheeze!</h3>
                                    <p>Estimated Delivery Time</p>
                                    <p>30 min</p>
                                    <h4 class="product-price">P 100</h4>
                                </div>
                                </div>
                                <form class="order-form">
                                    <div class="counter">
                                        <input type="number" value="1" min="0">
                                      </div>
                                      <button class="order-button">Confirm Order</button>
                                </form>
                        </div>
                        </div>

                        <div class="order-card">
                            <div class="order-card-header">
                                <div class="order-card-profile">
                                    <div>
                                        <img src="img/AR-9599-Quick-Easy-Brownies-ddmfs-4x3-697df57aa40a45f8a7bdb3a089eee2e5.jpg" alt="profile" class="product-pic"></img>
                                    </div>
                                
                                    <div class="order-card-content">
                                        <h3>Dark Brownies!</h3>
                                        <p>Estimated Delivery Time</p>
                                        <p>15 min</p>
                                        <h4 class="product-price">P 140</h4>
                                    </div>
                                    </div>
                                    <form class="order-form">
                                        <div class="counter">
                                            <input type="number" value="1" min="0">
                                          </div>
                                          <button class="order-button">Confirm Order</button>
                                    </form>
                            </div>
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
<body>

</body>

</html>