<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tips&eats";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    suffix VARCHAR(10),
    profile_pic VARCHAR(255),
    username VARCHAR(50) NOT NULL UNIQUE,
    gender ENUM('male', 'female', 'other') NOT NULL,
    birthday DATE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    street VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    barangay VARCHAR(100),
    postal_code VARCHAR(10) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('online', 'offline') NOT NULL DEFAULT 'offline'
);



CREATE TABLE Posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    post_pic VARCHAR(255),
    post_content VARCHAR(255),
    profile_pic VARCHAR(255),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    username VARCHAR(50),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Only set when a new row is inserted
    status ENUM('active', 'dismissed', 'reported') DEFAULT 'active'
);

CREATE TABLE Likes ( 
    like_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES Posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each comment
    post_id INT NOT NULL,                     -- Links the comment to a specific post
    user_id INT NOT NULL,                     -- ID of the user who made the comment
    comment_content TEXT NOT NULL,            -- The actual comment content
    profile_pic VARCHAR(255),                 -- User's profile picture
    first_name VARCHAR(100) NOT NULL,         -- First name of the user
    last_name VARCHAR(100) NOT NULL,          -- Last name of the user
    username VARCHAR(100) NOT NULL,           -- Username of the user
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the comment was created
    FOREIGN KEY (post_id) REFERENCES Posts(post_id) ON DELETE CASCADE, -- Link to Posts table
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE  -- Link to Users table
);

CREATE TABLE Follows (
    follow_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,  -- The user who is being followed
    follower_id INT NOT NULL,  -- The user who is following
    followed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp of when the follow occurred
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (follower_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE CommentLikes (
    like_id INT AUTO_INCREMENT PRIMARY KEY,
    comment_id INT NOT NULL,
    user_id INT NOT NULL,
    liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (comment_id) REFERENCES Comments(comment_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_title VARCHAR(255) NOT NULL,
    product_content TEXT NOT NULL,
    product_pic VARCHAR(255),
    price DECIMAL(10, 2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'dismissed', 'reported') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    seller_id INT NOT NULL,
    buyer_id INT NOT NULL,
    order_title VARCHAR(255) NOT NULL,
    order_price DECIMAL(10, 2) NOT NULL,
    order_quantity INT DEFAULT 1,
    order_finalprice DECIMAL(10, 2) NOT NULL,
    order_status ENUM('preparing', 'delivering', 'delivered', 'pending') DEFAULT 'pending',
    buyer_city VARCHAR(255) NOT NULL,
    buyer_number VARCHAR(20) NOT NULL,
    buyer_status ENUM('confirmed', 'cancelled', 'pending') DEFAULT 'pending',
    seller_city VARCHAR(255) NOT NULL,
    seller_status ENUM('approved', 'rejected', 'pending') DEFAULT 'pending',
    ordered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE PostReports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    reported_id INT NOT NULL,
    reporter_username VARCHAR(50),
    reported_username VARCHAR(50),
    report_type VARCHAR(50),
    report_issue VARCHAR(255),
    report_description VARCHAR(255),  -- Updated to VARCHAR(255)
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES Posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (reported_id) REFERENCES Users(user_id) ON DELETE CASCADE
);


CREATE TABLE ProductReports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    reported_id INT NOT NULL,
    reporter_username VARCHAR(50),
    reported_username VARCHAR(50),
    report_type VARCHAR(50),
    report_issue VARCHAR(255),
    report_description VARCHAR(255),  -- Updated to VARCHAR(255)
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (reported_id) REFERENCES Users(user_id) ON DELETE CASCADE
);


CREATE TABLE Reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each review
    product_id INT NOT NULL,                  -- Links the review to a specific product
    user_id INT NOT NULL,                     -- ID of the user who wrote the review
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5), -- Rating (1 to 5)
    review_content TEXT NOT NULL,             -- Review content
    profile_pic VARCHAR(255),                 -- User's profile picture
    first_name VARCHAR(100) NOT NULL,         -- First name of the user
    last_name VARCHAR(100) NOT NULL,          -- Last name of the user
    username VARCHAR(100) NOT NULL,           -- Username of the user
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the review was created
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE, -- Link to Products table
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE  -- Link to Users table
);



*/

?>


