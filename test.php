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

    // Directory of the profile picture  
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
    <title>Transparent Modal</title>  
</head>  
<body>  

    <!-- Button to open the modal -->  
    <button class="open-comment" onclick="openComment(10)">Open Modal</button>  

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
                    <input type="hidden" id="profile_pic" name="profile_pic" value="<?= $profile_img ?>">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" id="post_id" name="post_id" value="10">
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

    <script>  
        // Function to open the modal  
        function openComment() {  
            const modal = document.getElementById("comment-modal");  
            modal.style.display = "flex";  
            setTimeout(() => {  
                modal.style.opacity = "1";  
            }, 10); // Small delay to trigger the opacity transition  
        }  

        // Function to close the modal  
        function closeComment(event) {  
            const modal = document.getElementById("comment-modal");  
            if (event) {  
                event.stopPropagation(); // Prevent closing when clicking inside modal content  
            }  
            modal.style.opacity = "0";  
            setTimeout(() => {  
                modal.style.display = "none";  
            }, 300); // Matches the duration of the opacity transition  
        }  
    </script>  
</body>  
</html>