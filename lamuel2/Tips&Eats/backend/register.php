<?php
include 'connection.php';

$Myusername = 'lamuelbapilar';

function getGeoname($geonameId, $username) {
    $url = "http://api.geonames.org/getJSON?geonameId=$geonameId&username=lamuelbapilar";
    $response = file_get_contents($url);

    if ($response === FALSE) {
        die('Error occurred while fetching GeoName data.');
    }

    $data = json_decode($response, true);

    if (isset($data['name'])) {
        return $data['name'];
    } else {
        return 'Name not found';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $suffix = $_POST['suffix'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $street = $_POST['street'];
    $isAdmin = $_POST['is_admin'];

    // Convert GeoName IDs to text names
    $regionId = $_POST['region'];
    $provinceId = $_POST['province'];
    $cityId = $_POST['city'];
    $barangayId = $_POST['barangay'];

    $regionName = getGeoname($regionId, $username);
    $provinceName = getGeoname($provinceId, $username);
    $cityName = getGeoname($cityId, $username);
    $barangayName = getGeoname($barangayId, $username);

    $postalCode = $_POST['postalCode'];

    // Check if email or username already exists
    $checkSql = "SELECT * FROM users WHERE email='$email' OR username='$username'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email or Username already in use. Please try again with a different one.'); window.history.back();</script>";
    } else {
        // Handle the file upload
        if (isset($_FILES['userpic']) && $_FILES['userpic']['error'] == 0) {
            $profilePic = 'profilepic/' . time() . '_' . basename($_FILES['userpic']['name']);
            
            // Check if the file is uploaded successfully
            if (move_uploaded_file($_FILES['userpic']['tmp_name'], $profilePic)) {
            } else {
                echo "Error occurred while uploading the file.";
                $profilePic = NULL; // Set to NULL if upload fails
            }
        } else {
            $profilePic = NULL; // No file uploaded
        }

      // Insert user data into the database
    $sql = "INSERT INTO users (first_name, middle_name, last_name, suffix, profile_pic, username, gender, birthday, phone, email, password, street, region, province, city, barangay, postal_code, is_admin)
    VALUES ('$firstName', '$middleName', '$lastName', '$suffix', '$profilePic', '$username', '$gender', '$birthday', '$phone', '$email', '$password', '$street', '$regionName', '$provinceName', '$cityName', '$barangayName', '$postalCode', '$isAdmin')";

    if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registration successful!'); window.location.href = '../index.php';</script>";
        } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    }

    $conn->close();
}
?>
