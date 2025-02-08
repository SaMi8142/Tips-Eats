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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tips&eats";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM postreports WHERE status_report = 'Unresolved'";
$result = mysqli_query($conn, $sql);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="js/admin.js"></script>
</head>
<body>
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
                            <img src="img/chart-area.png" alt="">
                            <p>Home</p>
                        </div>
                        <div id="user-reports" onclick="window.location.href='admin.php'">
                            <img src="img/message-square-warning.png" alt="">
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
            <div class="title-search">
                <div id="title">
                    <div>
                        <p>Manage&nbsp;</p><p id="title-text">User Reports</p>
                    </div>
                </div>
                <div id="search">
                    <input type="text" name="" id="" placeholder="Search user...">
                </div>
            </div>
            <div class="table">
                <table>
                    <thead>
                        <td>Post/Product ID</td>
                        <td>Reported ID</td>
                        <td>Reported Username</td>
                        <td>Reporter Username</td>
                        <td>Report Type</td>
                        <td>Report Issue</td>
                        <td>Report Description</td>
                        <td>Action</td>
                    </thead>
                    <?php if (empty($data)) { ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No reports at the moment...</td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td><?php echo $row["post_id"];?></td>
                                <td><?php echo $row["reported_id"];?></td>
                                <td><?php echo $row["reported_username"];?></td>
                                <td><?php echo $row["reporter_username"];?></td>
                                <td>
                                    <div class="document-column" onclick="displayPost(<?php echo $row['post_id']; ?>)"><p><?php echo $row["report_type"];?></p></div>
                                </td>
                                <td><?php echo $row["report_issue"];?></td>
                                <td class="reportDesc"><?php echo $row["report_description"]?></td>
                                <td>
                                    <div class="action-column">
                                        <button id="check-btn" onclick="approveReport(<?php echo $row['post_id']; ?>, '<?php echo $row['report_type']; ?>')">
                                            <img src="img/circle-check.png" alt="">
                                        </button>
                                        <button id="x-btn" onclick="disapproveReport(<?php echo $row['post_id']; ?>, '<?php echo $row['report_type']; ?>')">
                                            <img src="img/circle-x.png" alt="">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 