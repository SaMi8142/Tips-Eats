<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}
include 'connection.php'; // Ensure database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

// Query to check if the user is an admin
$sql = "SELECT is_admin FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_admin);
$stmt->fetch();
$stmt->close();

// If user is an admin, execute the block
if ($is_admin == 1) {
    echo '<a href="home.php">Home</a>';
    echo '<a href="following.php">Following</a>';
    echo '<a href="marketplace.php">MarketPlace</a>';
    echo '<a href="orders.php">My Orders</a>';
    echo '<a href="morders.php">Product Orders</a>';
    echo '<a href="profile.php">My Profile</a>';
    echo '<a href="adminHome.php">Admin</a>';
    echo '<a href="#" id="logoutmobile">Log Out</a>';
} else {
    echo '<a href="home.php">Home</a>';
    echo '<a href="following.php">Following</a>';
    echo '<a href="marketplace.php">MarketPlace</a>';
    echo '<a href="orders.php">My Orders</a>';
    echo '<a href="morders.php">Product Orders</a>';
    echo '<a href="profile.php">My Profile</a>';
    echo '<a href="#" id="logoutmobile">Log Out</a>';
}
?>
