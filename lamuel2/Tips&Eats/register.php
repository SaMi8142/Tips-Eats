<?php

include ("connect.php");

if(isset($_POST['register'])){
    $firstName=$_POST['firstName'];
    $middleName=$_POST['middleName'];
    $lastName=$_POST['lastName'];  
    $suffix=$_POST['suffix'];
    $gender=$_POST['gender'];
    $birthday=$_POST['birthday'];
    $phoneNumber=$_POST['phoneNumber'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $street=$_POST['street'];
    $region=$_POST['regionInput'];
    $province=$_POST['provinceInput'];
    $city=$_POST['cityInput'];   
    $barangay=$_POST['barangayInput'];

    $checkEmail="SELECT * From registration where email='$email'";
    $result=$conn->query($checkEmail);
    if($result->num_rows>0){
        echo "Email Already Used!";
    }
    else{
        $insetQuery="INSERT INTO registration(firstName, middleName, lastName, suffix, gender, birthday, phoneNumber, email, password, street, region, province, city, barangay)
                        VALUES ('$firstName','$middleName','$lastName','$suffix','$gender','$birthday','$phoneNumber','$email','$password','$street','$region','$province','$city','$barangay')";
            if($conn->query($insetQuery)==TRUE){
                header("location: index.php");
            } else {
                echo "Error:".$conn->error;
            }
    }
}

?>