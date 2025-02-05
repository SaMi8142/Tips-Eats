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
    if ($action === "approve" && isset($data["post_id"])) {
        $id = intval($data["post_id"]);
        $sql1 = "DELETE FROM postreports WHERE post_id = $id";
        $sql2 = "UPDATE posts SET status = 'dismissed' WHERE post_id = $id";

        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
            echo "Report Approved!";
        } else {
            echo "Error approving report: " . mysqli_error($conn);
        }

    }

    // UPDATE User
    elseif ($action === "disapprove" && isset($data["post_id"])) {
        $id = intval($data["post_id"]);
        $sql1 = "DELETE FROM postreports WHERE post_id = $id";
        $sql2 = "UPDATE posts SET status = 'active' WHERE post_id = $id";

        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
            echo "Report disapproved!";
        } else {
            echo "Error disapproving report: " . mysqli_error($conn);
        }
    }

    // Invalid Action
    else {
        echo "Invalid request!";
    }
}

mysqli_close($conn);
?>