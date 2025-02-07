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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link rel="stylesheet" href='css/main.css'>
    <link rel="stylesheet" href='css/comment.css'> 
    <link rel="stylesheet" href='css/marketplace.css'> 
    <link rel="stylesheet" href='css/profile.css'> 
    <title>Main</title>
</head>
<body>
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
            <a href="following.php">
                <p>Following</p>
            </a>
            <a href="marketplace.php">
                <p>MarketPlace</p>
            </a>
            <a href="orders.php">
                <p>My Orders</p>
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

            <button class="profiletag-button" onclick="popup_logout()">···</button>
            <div class="dropdown-content" id="dropdown-content"> 
            <?php include 'backend/checkdropdown.php'; ?>
            </div>
           
        </div>
    </div>

    <!-- Middle section here! -->
    <div class="middle-section">
        <div class="header headtitle">  
        <h3 class="nav-logo">T&<span style="color: #994700;">Es</span></h3>
        <button class="nav-button" onclick="nav_logout()">···</button>
            <div class="navdown-content" id="navdown-content"> 
            <?php include 'backend/checknavdown.php'; ?>
            </div>
            <a href="mmarketplace.php" class="headtitle-order ">
                <p>My Products</p>
            </a>
            <a href="profile.php" class="headtitle-middle underline">
             <p style="color: #994700;">My Profile</p>
            </a>
            <a href="mhome.php" class="headtitle-order">
             <p>My Posts</p>
            </a>
        </div>


        <!-- Sample Post here! -->

       <div class="post-section">

       <div class="profile-card">
                        <div class="profile-card-header">
                            <div class="profile-card-profile">
                                <div>
                                    <img src="<?= $profile_img ?>" alt="profile" class="profile-pic"></img>
                                    <button class="profile-button" onclick="openUpdateProfile()">Update Profile</button>
                                </div>
                            
                                <div class="profile-card-content">
                                    <h2>My <span style="color: #994700;">Profile</span></h2>
                                    <h3><?php echo $first_name . ' ' . $last_name; ?></h3>
                                    <p>@<?php echo $username; ?></p>
                                    <p><?php echo $email; ?></p>
                                    <p><?= $street ?> <?= $barangay ?>, <?= $city ?> <?= $province ?> <?= $region ?> <?= $postal_code ?></p>
                                    <p><?php echo $phone; ?></p>
                                    <p><?php echo $birthday; ?> <?php echo $gender; ?></p>
                                </div>
                               </div>
                        </div>
                        </div>
                        <!-- Plotly Chart -->
                        <div id="myPlot" style="width:100%; max-width:700px"></div>
                        

            <script>
            <?php include 'backend/sales.php'; ?>
            </script>
        </div>             
        </div>

<!-- Update Profile Modal -->
<div id="report-post-modal" class="add-product-modal" onclick="closeUpdateProfile(event)">
    <div class="add-product-body Profilemodal" onclick="event.stopPropagation();">
        <div class="productform">
            <h2>Update <span style="color:#994700;">Profile</span></h2> 
            <form id="profileform" action="backend/edit_profile.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="profile_user_id" name="user_id" value="<?= $user_id ?>">
                <input type="text" id="profile_first_name" name="profile_first_name" class="marketplace-input-box" placeholder="First Name" value="<?= $first_name ?>" required>
                <input type="text" id="profile_middle_name" name="profile_middle_name" class="marketplace-input-box" placeholder="Middle Name" value="<?= $middle_name ?>" required>
                <input type="text" id="profile_last_name" name="profile_last_name" class="marketplace-input-box" placeholder="Last Name" value="<?= $last_name ?>" required>
                    <input type="text" id="profile_suffix" name="profile_suffix" class="marketplace-input-box" placeholder="suffix (optional)" >
                    <input type="text" id="profile_username" name="profile_username" class="marketplace-input-box" placeholder="username" value="<?= $_SESSION['username']?>" required>
                    <input type="date" id="profile_birthday" name="profile_birthday" class="marketplace-input-box" placeholder="birthday" value="<?php echo $birthday; ?>" required>
                    <input type="number" maxlength="11" id="profile_phone" name="profile_phone" class="marketplace-input-box" placeholder="Phone Number" value="<?php echo $phone; ?>" required>
                    <input type="password" id="profile_oldpass" name="profile_oldpass" class="marketplace-input-box" placeholder="old password (optional)" value="" >
                    <input type="password" id="profile_newpass" name="profile_newpass" class="marketplace-input-box" placeholder="new password (optional)" value="" >
                    <input type="password" id="profile_confirmpass" name="profile_confirmpass" class="marketplace-input-box" placeholder="confirm password (optional)" value="" >
                    <div class="custom-file-input">
                        <label for="profile_profile_pic" class="custom-file-label">Choose File</label>
                        <input type="file" id="profile_profile_pic" name="profile_profile_pic" class="marketplace-file-box" accept="image/*"  >
                        <span id="profile_profile_name" class="file-name">No file chosen (optional)</span>
                    </div>                 
                    <select id="profile_gender" name="profile_gender" class="marketplace-input-box" value="<?= $gender ?>" required>
                        <option value="male">male</option>
                        <option value="female">female</option>
                        <option value="other">other</option>
                    </select>
                        <input type="text" id="profile_street" name="profile_street" class="marketplace-input-box" placeholder="street" value="<?= $street ?>" required>
                        <input type="text" id="profile_barangay" name="profile_barangay" class="marketplace-input-box" placeholder="barangay" value="<?= $barangay ?>" required>
                        <input type="text" id="profile_postal_code" name="profile_postal_code" class="marketplace-input-box" placeholder="postal_code" value="<?= $postal_code ?>" required>
                        <select id="profile_region" name="profile_region" class="marketplace-input-box" onchange="updateProvinces()" required>
                    <option value="<?= $region ?>"><?= $region ?></option>
                            <option value="NCR">NCR</option>
                            <option value="CAR">CAR</option>
                            <option value="Region 1">Region 1</option>
                            <option value="Region 2">Region 2</option>
                            <option value="Region 3">Region 3</option>
                            <option value="Region 4A">Region 4A</option>
                            <option value="Region 4B">Region 4B</option>
                            <option value="Region 5">Region 5</option>
                            <option value="Region 6">Region 6</option>
                            <option value="Region 7">Region 7</option>
                            <option value="Region 8">Region 8</option>
                            <option value="Region 9">Region 9</option>
                            <option value="Region 10">Region 10</option>
                            <option value="Region 11">Region 11</option>
                            <option value="Region 12">Region 12</option>
                            <option value="CARAGA">CARAGA</option>
                            <option value="BARMM">BARMM</option>
                    </select>
                    <select id="profile_province" name="profile_province" class="marketplace-input-box" onchange="updateCities()" required>
                    <option value="<?= $province ?>" ><?= $province ?></option>
                    </select>
                    <select id="profile_city" name="profile_city" class="marketplace-input-box" required>
                    <option value="<?= $city ?>" ><?= $city ?></option>
                    </select>
                <button type="submit" class="add-product-button">Update Profile</button>
            </form>
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
        <?php include 'backend/recommendation.php'; ?>

        </div>
    </div>

</div>


<script src="js/main.js"></script>
<script src="js/followingpost.js"></script>
<script src="js/profile.js"></script>

<script>
    document.getElementById("profileform").addEventListener("submit", function() {
        console.log("Form is being submitted!");
    });
</script>

<script>
const regions = {
    "NCR": {
        "Metro Manila": ["Caloocan City", "Las Piñas City", "Makati City", "Malabon City", "Mandaluyong City", "Manila City", "Marikina City", "Muntinlupa City", "Navotas City", "Parañaque City", "Pasay City", "Pasig City", "Pateros City", "Quezon City", "San Juan City", "Taguig City", "Valenzuela City"]
    },
    "CAR": {
        "Abra": ["Bangued City", "Dolores City", "Lagangilang City", "Peñarrubia City"],
        "Apayao": ["Conner City", "Flora City", "Kabugao City", "Luna City"],
        "Benguet": ["La Trinidad City", "Baguio City", "Itogon City", "Tuba City"],
        "Ifugao": ["Lagawe City", "Kiangan City", "Hungduan City", "Banaue City"],
        "Kalinga": ["Tabuk City", "Balbalan City", "Lubuagan City", "Pasil City"],
        "Mountain Province": ["Bontoc City", "Sagada City", "Tadian City", "Bauko City"]
    },
    "Region 1": {
        "Ilocos Norte": ["Laoag City", "Batac City", "Pasuquin City", "Piddig City"],
        "Ilocos Sur": ["Vigan City", "Candon City", "Narvacan City", "Santa Maria City"],
        "La Union": ["San Fernando City", "Bacnotan City", "Bauang City", "Naguilian City"],
        "Pangasinan": ["Dagupan City", "San Carlos City", "Urdaneta City", "Alaminos City", "Lingayen City"]
    },
    "Region 2": {
        "Batanes": ["Basco City", "Itbayat City", "Ivana City", "Mahatao City"],
        "Cagayan": ["Tuguegarao City", "Aparri City", "Baggao City", "Gonzaga City"],
        "Isabela": ["Ilagan City", "Cauayan City", "Santiago City", "Roxas City"],
        "Nueva Vizcaya": ["Bayombong City", "Solano City", "Aritao City", "Kasibu City"],
        "Quirino": ["Cabarroguis City", "Diffun City", "Maddela City", "Saguday City"]
    },
    "Region 3": {
        "Aurora": ["Baler", "Casiguran", "Dilasag", "Dingalan"],
        "Bataan": ["Balanga", "Dinalupihan", "Mariveles", "Orion"],
        "Bulacan": ["Malolos", "Meycauayan", "San Jose del Monte", "Santa Maria"],
        "Nueva Ecija": ["Cabanatuan", "Gapan", "San Jose", "Palayan"],
        "Pampanga": ["San Fernando", "Angeles City", "Mabalacat", "Porac"],
        "Tarlac": ["Tarlac City", "Concepcion", "Paniqui", "Capas"],
        "Zambales": ["Olongapo", "Subic", "San Narciso", "Iba"]
    },
    "Region 4A": {
        "Batangas": ["Batangas City", "Lipa", "Tanauan", "Balayan"],
        "Cavite": ["Cavite City", "Tagaytay", "Trece Martires", "Bacoor"],
        "Laguna": ["Santa Rosa", "Calamba", "San Pablo", "Los Baños"],
        "Quezon": ["Lucena", "Tayabas", "Sariaya", "Candelaria"],
        "Rizal": ["Antipolo", "Cainta", "Binangonan", "Taytay"]
    },
    "Region 4B": {
        "Marinduque": ["Boac", "Buenavista", "Gasan", "Mogpog"],
        "Occidental Mindoro": ["Mamburao", "Sablayan", "San Jose", "Calintaan"],
        "Oriental Mindoro": ["Calapan", "Pinamalayan", "Bansud", "Gloria"],
        "Palawan": ["Puerto Princesa", "Coron", "Roxas", "Brooke's Point"],
        "Romblon": ["Romblon", "Odiongan", "Cajidiocan", "Magdiwang"]
    },
    "Region 5": {
        "Albay": ["Legazpi", "Tabaco", "Ligao", "Daraga"],
        "Camarines Norte": ["Daet", "Basud", "Labo", "Mercedes"],
        "Camarines Sur": ["Naga", "Iriga", "Pili", "Caramoan"],
        "Catanduanes": ["Virac", "Bato", "San Andres", "Bagamanoc"],
        "Masbate": ["Masbate City", "Aroroy", "Mandaon", "Balud"],
        "Sorsogon": ["Sorsogon City", "Bulusan", "Casiguran", "Irosin"]
    },
    "Region 6": {
        "Aklan": ["Kalibo", "Malay", "Ibajay", "Numancia"],
        "Antique": ["San Jose", "Sibalom", "Culasi", "Pandan"],
        "Capiz": ["Roxas City", "Panitan", "Pontevedra", "Dumarao"],
        "Guimaras": ["Jordan", "Buenavista", "Nueva Valencia", "Sibunag"],
        "Iloilo": ["Iloilo City", "Passi", "Pototan", "Santa Barbara"],
        "Negros Occidental": ["Bacolod", "Silay", "Talisay", "San Carlos"]
    },
    "Region 7": {
        "Bohol": ["Tagbilaran", "Ubay", "Talibon", "Loon"],
        "Cebu": ["Cebu City", "Mandaue", "Lapu-Lapu", "Danao"],
        "Negros Oriental": ["Dumaguete", "Bais", "Tanjay", "Guihulngan"],
        "Siquijor": ["Siquijor", "Larena", "San Juan", "Lazi"]
    },
    "Region 8": {
        "Biliran": ["Naval", "Kawayan", "Almeria", "Caibiran"],
        "Eastern Samar": ["Borongan", "Guiuan", "Oras", "Balangiga"],
        "Leyte": ["Tacloban", "Ormoc", "Palo", "Baybay"],
        "Northern Samar": ["Catarman", "Calbayog", "San Isidro", "Gamay"],
        "Samar": ["Catbalogan", "Calbayog", "San Jorge", "Paranas"],
        "Southern Leyte": ["Maasin", "Sogod", "Saint Bernard", "Hinunangan"]
    },
    "Region 9": {
        "Zamboanga del Norte": ["Dipolog", "Dapitan", "Sindangan", "Katipunan"],
        "Zamboanga del Sur": ["Pagadian", "Zamboanga City", "Dumingag", "Molave"],
        "Zamboanga Sibugay": ["Ipil", "Kabasalan", "Mabuhay", "Titay"]
    },
    "Region 10": {
        "Bukidnon": ["Malaybalay", "Valencia", "Maramag", "Quezon"],
        "Camiguin": ["Mambajao", "Catarman", "Sagay", "Guinsiliban"],
        "Lanao del Norte": ["Iligan", "Tubod", "Lala", "Kapatagan"],
        "Misamis Occidental": ["Oroquieta", "Ozamiz", "Tangub", "Clarin"],
        "Misamis Oriental": ["Cagayan de Oro", "Gingoog", "Jasaan", "El Salvador"]
    },
    "Region 11": {
        "Davao de Oro": ["Nabunturan", "Monkayo", "Mawab", "Pantukan"],
        "Davao del Norte": ["Tagum", "Panabo", "Carmen", "Santo Tomas"],
        "Davao del Sur": ["Davao City", "Digos", "Bansalan", "Magsaysay"],
        "Davao Occidental": ["Malita", "Santa Maria", "Don Marcelino", "Jose Abad Santos"],
        "Davao Oriental": ["Mati", "Baganga", "Cateel", "Caraga"]
    },
    "Region 12": {
        "Cotabato": ["Kidapawan", "Matalam", "Makilala", "M'lang"],
        "Sarangani": ["Alabel", "Glan", "Maasim", "Maitum"],
        "South Cotabato": ["Koronadal", "General Santos", "Polomolok", "Tupi"],
        "Sultan Kudarat": ["Isulan", "Tacurong", "Lambayong", "Lebak"]
    },
    "CARAGA": {
        "Agusan del Norte": ["Butuan", "Cabadbaran", "Buenavista", "Nasipit"],
        "Agusan del Sur": ["Bayugan", "San Francisco", "Bunawan", "Prosperidad"],
        "Dinagat Islands": ["San Jose", "Loreto", "Cagdianao", "Tubajon"],
        "Surigao del Norte": ["Surigao City", "Dapa", "Placer", "Claver"],
        "Surigao del Sur": ["Tandag", "Bislig", "Cagwait", "Carrascal"]
    },
    "BARMM": {
        "Basilan": ["Isabela City", "Lamitan", "Sumisip", "Tuburan"],
        "Lanao del Sur": ["Marawi", "Wao", "Bumbaran", "Malabang"],
        "Maguindanao": ["Cotabato City", "Datu Odin Sinsuat", "Buluan", "Parang"],
        "Sulu": ["Jolo", "Indanan", "Maimbung", "Siasi"],
        "Tawi-Tawi": ["Bongao", "Mapun", "Panglima Sugala", "Sitangkai"]
    }
};

// Update provinces based on selected region
function updateProvinces() {
    const regionSelect = document.getElementById("profile_region");
    const provinceSelect = document.getElementById("profile_province");
    const selectedRegion = regionSelect.value;

    // Clear previous province and city selections
    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    document.getElementById("profile_city").innerHTML = '<option value="">Select City</option>';

    // Populate provinces based on selected region
    if (selectedRegion && regions[selectedRegion]) {
        const provinces = Object.keys(regions[selectedRegion]);
        provinces.forEach(province => {
            const option = document.createElement("option");
            option.value = province;
            option.text = province;
            provinceSelect.add(option);
        });
    }
}

// Update cities based on selected province
function updateCities() {
    const regionSelect = document.getElementById("profile_region").value;
    const provinceSelect = document.getElementById("profile_province").value;
    const citySelect = document.getElementById("profile_city");

    // Clear previous city selection
    citySelect.innerHTML = '<option value="">Select City</option>';

    // Populate cities based on selected province
    if (regionSelect && provinceSelect && regions[regionSelect][provinceSelect]) {
        const cities = regions[regionSelect][provinceSelect];
        cities.forEach(city => {
            const option = document.createElement("option");
            option.value = city;
            option.text = city;
            citySelect.add(option);
        });
    }
}

</script>

</body>

</html>

