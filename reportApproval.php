<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tips&eats";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["action"])) {
    $action = $data["action"];

    // DELETE User
    if ($action === "approve" && isset($data["post_id"]) && isset($data["report_type"])) {
        $id = intval($data["post_id"]);
        $report_type = $data["report_type"];
        if($report_type == 'Post'){
            $sql1 = "UPDATE postreports SET status_report = 'Resolved' WHERE post_id = $id and report_type = '$report_type'";
            $sql2 = "UPDATE posts SET status = 'dismissed' WHERE post_id = $id and report_type = '$report_type'";
        } else {
            $sql1 = "UPDATE postreports SET status_report = 'Resolved' WHERE post_id = $id and report_type = '$report_type'";
            $sql2 = "UPDATE products SET status = 'dismissed' WHERE product_id = $id and report_type = '$report_type'";
        }
        
        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
            echo "Report Approved!";
        } else {
            echo "Error approving report: " . mysqli_error($conn);
        }

    }

    // UPDATE User
    if ($action === "disapprove" && isset($data["post_id"]) && isset($data["report_type"])) {
        $id = intval($data["post_id"]);
        $report_type = $data["report_type"];
        if($report_type == 'Post'){
            $sql1 = "UPDATE postreports SET status_report = 'Resolved' WHERE post_id = $id and report_type = '$report_type'";
            $sql2 = "UPDATE posts SET status = 'active' WHERE post_id = $id and report_type = '$report_type'";
        } else {
            $sql1 = "UPDATE postreports SET status_report = 'Resolved' WHERE post_id = $id and report_type = '$report_type'";
            $sql2 = "UPDATE products SET status = 'active' WHERE product_id = $id and report_type = '$report_type'";
        }
        
        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
            echo "Report Approved!";
        } else {
            echo "Error approving report: " . mysqli_error($conn);
        }

    }

    else {
        echo "Invalid request!";
    }
}

mysqli_close($conn);
?>