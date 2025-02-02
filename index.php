<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login-register.css">
</head>

<body>
    <div class="login-container">
        <div class="left-section">
            <div class="login-form" id="loginForm">
                <h2>Login</h2>
                <form action="backend/login.php" method="post">
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn-custom">Login</button>
                    <p class="text-center mt-3">
                        No Account? <a href="#registrationForm" id="registerLink">Register Here!</a>
                    </p>
                </form>
            </div>

            <div class="carousel left-carousel" id="leftCarousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/backgroundCans1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img src="img/backgroundCans2.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img src="img/backgroundCans3.jpg" alt="Third slide">
                    </div>
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="login-form" id="registrationForm" style="display: none;">
                <div class="scrollable-box">
                    <h2>Register</h2>
                    <form action="backend/register.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-register" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="middleName" class="form-label">Middle Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-register" id="middleName" name="middleName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-register" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control-register" id="suffix" name="suffix">
                        </div>
                        <div class="form-group">
                            <label for="userpic" class="form-label">Profile Pic</label>
                            <input type="file" accept="image/*" class="form-control-register" id="userpic" name="userpic">
                        </div>
                        <div class="form-group">
                            <label for="usertag" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-register" placeholder="jamesBond" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="other" value="other" required>
                                <label class="form-check-label" for="other">Other</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthday" class="form-label">Birthday <span class="text-danger">*</span></label>
                            <input type="date" class="form-control-register" id="birthday" name="birthday" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control-register" id="phone" name="phone" placeholder="09485798284" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control-register" id="email" name="email" placeholder="example@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control-register" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="street" class="form-label">Street <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-register" id="street" name="street" required>
                        </div>
                        <div class="form-group">
                            <label for="region" class="form-label">Region <span class="text-danger">*</span></label>
                            <select class="form-control" id="region" name="region" onchange="updateProvinces()" required>
                        <option value="">Select Region</option>
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
                        </div>
                        <div class="form-group">
                            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                            <select class="form-control" id="province" name="province" onchange="updateCities()" required>
                        <option value="" >Select Province</option>
                    </select>
                        </div>
                        <div class="form-group">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-control" id="city" name="city" required>
                        <option value="" >Select City</option>
                    </select>
                        </div>
                        <div class="form-group">
                            <label for="barangay" class="form-label">Barangay</label>
                            <input type="text" class="form-control" id="barangay" name="barangay" required>
                        </div>
                        <div class="form-group">
                            <label for="postalCode" class="form-label">Postal Code / Zip Code <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="postalCode" name="postalCode" placeholder="1126" required>
                        </div>
                        <!-- input for admin or user change the value to 1 for admin 0 for user-->
                        <input type="hidden" name="is_admin" id="is_admin" value="0">

                        <button type="submit" class="btn-custom">Register</button>
                        <p class="text-center mt-3 form-label">
                            Already have an account? <a href="#loginForm" id="loginLink">Login Here!</a>
                        </p>
                    </form>
                </div>
            </div>
            <div class="carousel right-carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/backgroundCans1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img src="img/backgroundCans2.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img src="img/backgroundCans3.jpg" alt="Third slide">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/login-register.js"></script>
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
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const selectedRegion = regionSelect.value;

    // Clear previous province and city selections
    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    document.getElementById("city").innerHTML = '<option value="">Select City</option>';

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
    const regionSelect = document.getElementById("region").value;
    const provinceSelect = document.getElementById("province").value;
    const citySelect = document.getElementById("city");

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
