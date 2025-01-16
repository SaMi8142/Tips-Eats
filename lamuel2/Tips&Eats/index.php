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
                            <select class="form-control" id="region" name="region" onchange="loadProvinces()" required>
                                <option value="" disabled selected>Select Region</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                            <select class="form-control" id="province" name="province" onchange="loadCities()" required>
                                <option value="" disabled selected>Select Province</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-control" id="city" name="city" onchange="loadBarangays()" required>
                                <option value="" disabled selected>Select City</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="barangay" class="form-label">Barangay</label>
                            <select class="form-control" id="barangay" name="barangay">
                                <option value="" disabled selected>Select Barangay</option>
                            </select>
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
   
</body>

</html>
