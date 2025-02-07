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
    <title>Document</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <button class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </button>
    
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
                        <div id="account-verif" onclick="window.location.href='adminHome.php'">
                            <img src="img/house.png" alt="Home-icon">
                            <p>Home</p>
                        </div>
                        <div id="user-reports" onclick="window.location.href='admin.php'">
                            <img src="img/message-square-warning.png" alt="Reports-icon">
                            <p>User Reports</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-sidenavbar">
                <div class="profile-container">
                    <div class="admin-pic">
                        <img src="<?= $profile_img ?>" alt="" width="35px" style="border-radius: 50%; border: 2px solid rgb(19, 218, 19)">
                    </div>
                    <div class="admin-info">
                        <p><strong><?php echo $first_name . ' ' . $last_name; ?></strong><br>Administrator</p>
                    </div>
                    <div class="logoutbtn">
                        <div class="popup_logout" id="popuplogout"> 
                            <a href="index.php">Log Out</a> 
                            <a href="home.php">Home</a>
                        </div>
                        <img src="img/ellipsis.png" alt="" onclick="popup_logout()" style="cursor: pointer;">
                    </div>
                </div>
            </div>
        </div>
        <div class="info-page">
            <div id="title">
                <div>
                    <p>Welcome Admin&nbsp;</p><p id="title-text"><?php echo $first_name; ?>!</p>
                </div>
            </div>
            <div class="main-content">
                <div class="report-section">
                    <div id="first-row">
                        <div class="kpi">
                            <p>Active Users</p>
                            <p class="value-indicator" id="activeUsersCount">0</p>
                        </div>
                        <div class="kpi">
                            <p>Total No. of Reports</p>
                            <p class="value-indicator" id="totalReportCount">0</p>
                        </div>
                        <div class="kpi">
                            <p>Pending Approvals</p>
                            <p class="value-indicator" id="totalPendingCount">0</p>
                        </div>
                    </div>
                    <div id="second-row">
                        <div class="report-charts">
                            <p>Total Number of Reports per Month</p>
                            <canvas id="reportLineChart"></canvas>
                        </div>
                        <div class="report-charts">
                            <p>Total Number of Reports per Report Issue</p>
                            <canvas id="reportPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/admin.js"></script>

</body>
</html>