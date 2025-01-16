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

include 'backend/connection.php';

// Fetch all posts with like and comment counts
$stmt = $pdo->query("
    SELECT posts.*, 
           (SELECT COUNT(*) FROM likes WHERE post_id = posts.post_id) AS like_count,
           (SELECT COUNT(*) FROM comments WHERE post_id = posts.post_id) AS comment_count
    FROM posts
");



// Fetch posts
$stmt = $pdo->query("SELECT posts.*, users.first_name, users.last_name, users.username, users.profile_pic 
                     FROM posts 
                     JOIN users ON posts.user_id = users.user_id 
                     ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch comments for each post
foreach ($posts as &$post) {
    $post_id = $post['post_id'];
    $comment_stmt = $pdo->prepare("SELECT comment_text, first_name, last_name FROM comments
                                  JOIN users ON comments.user_id = users.user_id
                                  WHERE post_id = ?");
    $comment_stmt->execute([$post_id]);
    $post['comments'] = $comment_stmt->fetchAll();
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
            <a href="home.php" class="headtitle-newsfeed">
                <p>NewsFeed</p>
            </a>
            <a href="following.php" class="headtitle-follow">
                <p>Following</p>
            </a>
        </div>
        <!-- Post Form here! -->
<form action="create_post.php" method="POST" enctype="multipart/form-data">
    <div class="postform">
        <div class="post-card">
            <div class="post-card-pic">
                <img src="<?= $profile_img ?>" alt="profile" class="profile"></img>
            </div>
            <textarea name="content" class="input-box" rows="3" placeholder="Share your recipes and ideas.." required></textarea>
        </div>
        <div class="post-button">
            <div class="post-button-left">
                <label for="fileUpload">Image</label>
                <input type="file" id="fileUpload" name="image" accept="image/*">
            </div>
            <button type="submit" class="post-button-right">
                <p>Post</p>
            </button>
        </div>
    </div>
</form>


        <!-- Sample Post here! -->
		
		    <?php foreach ($posts as $post): ?>
<div class="post-container">
<div class="post-container-profile">
<div class="profiletag-pic">
            <img src="<?= $profile_img ?>" alt="profile" class="profile"></img>
            </div>
			
	<div class="post-container-content">
    <h3><?php echo $first_name . ' ' . $last_name; ?></h3>
	<div class="post-container-body">
    <pre><?= htmlspecialchars($post['content']) ?></pre>
	</div>
	</div>
	</div>
	
    <?php if (!empty($post['image'])): ?>
    <div class="post-container-img">
        <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post Image">
    </div>
    <?php endif; ?>
	
	
     <div class="post-container-react-buttons">
        <button class="like-button" data-post-id="<?= $post['post_id'] ?>" placeholder= "Press">Like (<?= $post['like_count'] ?? 0 ?>)</button>
        <button class="comment-button" data-post-id="<?= $post['post_id'] ?>" placeholder="Thoughts?">Comment (<?= $post['comment_count'] ?? 0 ?>)</button>
        <button>Follow</button>
    </div>
	
	<!-- Display comments under the post -->
    <div class="comments-container">
        <?php if (!empty($post['comments'])): ?>
            <?php foreach ($post['comments'] as $comment): ?>
                
				<div class="post-container-profile">
				<div class="profiletag-pic">
            <img src="<?= $profile_img ?>" alt="profile" class="profile"></img>
            </div>
			<div class="post-container-content">
                    <strong><?= htmlspecialchars($comment['first_name'] . ' ' . $comment['last_name']) ?>:</strong>
                    <p><?= htmlspecialchars($comment['comment_text']) ?></p>
                </div>
				</div>
				
            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
    </div>
	
</div>

    <?php endforeach; ?>
		

        <div class="post-section">
            <div class="post-container">
                <div class="post-container-profile">
                    <div>
                        <img src="img/Avatar Image.png" alt="profile" class="profile"></img>
                    </div>
                    <div class="post-container-content">
                        <h3>Allen Siddayao · 4 hrs ago</h3>
                        <p>@allenibba123</p>
                    </div>
                </div>
                <div class="post-container-body">
                    <pre>Hey foodies! 🌟 I just whipped up the fluffiest pancakes ever, and I couldn't wait to share the recipe with you all! Perfect for a cozy breakfast or brunch. Here's how you can make them too:                    

 · 1 cup all-purpose flour
 · 2 tablespoons sugar
 · 1 tablespoon baking powder
 · 1/2 teaspoon salt
 · 1 cup milk
 · 1 large egg
 · 2 tablespoons melted butter
 · 1 teaspoon vanilla extract
                </pre>
                </div>
                <div class="post-container-img">
                    <img src="img/pexels-ash-craig-122861-376464.jpg" alt="profile"></img>

                    <div class="post-container-react">
                        <div class="post-container-react-buttons">
                            <button class="like">Like</button>
                            <button class="comment">Comment</button>
                            <button class="follow">Follow</button>
                            <button class="order">Make an order</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="post-container">
                <div class="post-container-profile">
                    <div>
                        <img src="img/Avatar Image5.png" alt="profile" class="profile"></img>
                    </div>
                    <div class="post-container-content">
                        <h3>Eli Thompson · 15 hrs ago</h3>
                        <p>@FoodieExplorerEli</p>
                    </div>
                </div>
                <div class="post-container-body">
                    <pre>Hey everyone! 👋 I just whipped up the most indulgent Leche Flan, and I'm thrilled to share the recipe with you all! Perfect for a sweet treat after dinner or a special occasion. Here's how you can make it too:

· 10 large egg yolks 
· 1 can (14 ounces) sweetened condensed milk 
· 1 can (12 ounces) evaporated milk 
· 1 teaspoon vanilla extract 
· 1 cup sugar (for caramel)
                </pre>
                </div>
                <div class="post-container-img">
                    <img src="img/Leche-Flan-with-Cream-Cheese-7.jpg" alt="profile"></img>

                    <div class="post-container-react">
                        <div class="post-container-react-buttons">
                            <button class="like">Like</button>
                            <button class="comment">Comment</button>
                            <button class="follow">Follow</button>
                            <button class="order">Make an order</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="post-container">
                <div class="post-container-profile">
                    <div>
                        <img src="img/Avatar Image4.png" alt="profile" class="profile"></img>
                    </div>
                    <div class="post-container-content">
                        <h3>Austin Arthur · 13 hrs ago</h3>
                        <p>@HealthyAustin</p>
                    </div>
                </div>
                <div class="post-container-body">
                    <pre>Hey everyone! 👋 I just made the creamiest, most delightful homemade mac and cheese, and I'm excited to share the recipe with you all! Perfect for a comforting dinner or a hearty side dish. Here's how you can make it too:

· 8 ounces elbow macaroni 
· 2 cups shredded cheddar cheese 
· 1/2 cup grated Parmesan cheese 
· 3 cups milk 
· 1/4 cup butter 
· 1/4 cup all-purpose flour 
· 1/2 teaspoon salt
· 1/4 teaspoon black pepper 
· 1/4 teaspoon paprika
                </pre>
                </div>
                <div class="post-container-img">
                    <img src="img/tini-mac-cheese-4894w.jpg" alt="profile"></img>

                    <div class="post-container-react">
                        <div class="post-container-react-buttons">
                            <button class="like">Like</button>
                            <button class="comment">Comment</button>
                            <button class="follow">Follow</button>
                            <button class="order">Make an order</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="post-container">
                <div class="post-container-profile">
                    <div>
                        <img src="img/Avatar Image6.png" alt="profile" class="profile"></img>
                    </div>
                    <div class="post-container-content">
                        <h3>Hannah· 8 hrs ago</h3>
                        <p>@HomeChefHannah</p>
                    </div>
                </div>
                <div class="post-container-body">
                    <pre>Hey everyone! 🙌 I just baked the most decadent, fudgy brownies, and I can't wait to share the recipe with you all! Perfect for a sweet treat any time of day. Here’s how you can make them too:

· 1/2 cup unsalted butter 
· 1 cup granulated sugar 
· 2 large eggs · 1 teaspoon vanilla extract 
· 1/3 cup unsweetened cocoa powder 
· 1/2 cup all-purpose flour 
· 1/4 teaspoon salt 
· 1/4 teaspoon baking powder
                </pre>
                </div>
                <div class="post-container-img">
                    <img src="img/AR-9599-Quick-Easy-Brownies-ddmfs-4x3-697df57aa40a45f8a7bdb3a089eee2e5.jpg"
                        alt="profile"></img>

                    <div class="post-container-react">
                        <div class="post-container-react-buttons">
                            <button class="like">Like</button>
                            <button class="comment">Comment</button>
                            <button class="follow">Follow</button>
                            <button class="order">Make an order</button>
                        </div>
                    </div>
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

<body>

</body>

</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Like Button
    const likeButtons = document.querySelectorAll('.like-button');
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = button.getAttribute('data-post-id');
            
            fetch('like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'post_id=' + postId,
            })
            .then(response => response.text())
            .then(likeCount => {
                // Update like count in the button text
                button.innerHTML = `Like (${likeCount})`;
            });
        });
    });

    // Handle Comment Button
    const commentButtons = document.querySelectorAll('.comment-button');
    commentButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = button.getAttribute('data-post-id');
            const commentText = prompt("Enter your comment:");
            
            if (commentText) {
                fetch('comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'post_id=' + postId + '&comment_text=' + encodeURIComponent(commentText),
                })
                .then(response => response.text())
                .then(commentCount => {
                    // Update comment count in the button text
                    button.innerHTML = `Comment (${commentCount})`;
                });
            }
        });
    });
});
</script>