document.addEventListener("DOMContentLoaded", function () {
    document.body.classList.add('fade-in');

    // Hide the left carousel initially, but show the right carousel
    const leftCarousel = document.querySelector('#leftCarousel');
    leftCarousel.style.display = 'none';

    const rightCarousel = document.querySelector('.right-carousel');
    rightCarousel.style.display = 'block'; // Keep the right carousel visible initially

    // Left Carousel Script
    let leftCurrentIndex = 0;
    const leftItems = document.querySelectorAll('.left-carousel .carousel-item');
    const leftItemCount = leftItems.length;
    const leftInner = document.querySelector('.left-carousel .carousel-inner');

    function showNextLeftItem() {
        leftCurrentIndex = (leftCurrentIndex + 1) % leftItemCount;
        const offset = leftCurrentIndex * -100 / leftItemCount;
        leftInner.style.transform = `translateX(${offset}%)`;
    }
    setInterval(showNextLeftItem, 5000); // Change image every 5 seconds

    // Right Carousel Script
    let rightCurrentIndex = 0;
    const rightItems = document.querySelectorAll('.right-carousel .carousel-item');
    const rightItemCount = rightItems.length;
    const rightInner = document.querySelector('.right-carousel .carousel-inner');

    function showNextRightItem() {
        rightCurrentIndex = (rightCurrentIndex + 1) % rightItemCount;
        const offset = rightCurrentIndex * -100 / rightItemCount;
        rightInner.style.transform = `translateX(${offset}%)`;
    }
    setInterval(showNextRightItem, 5000); // Change image every 5 seconds

    // Add event listener to "Register Here!" link
    const registerLink = document.querySelector('#registerLink');
    registerLink.addEventListener('click', function () {
        const loginForm = document.querySelector('#loginForm');
        loginForm.style.display = 'none'; // Hide the login form

        // Fade out right carousel and fade in left carousel
        rightCarousel.classList.add('fade-out');
        setTimeout(function () {
            rightCarousel.style.display = 'none'; // Hide right carousel after fade out
            leftCarousel.style.display = 'block'; // Show left carousel
            leftCarousel.classList.add('fade-in');
            leftCarousel.classList.remove('fade-out'); // Remove fade-out class

            // Show the registration form
            const registrationForm = document.querySelector('#registrationForm');
            registrationForm.style.display = 'block'; // Display registration form
        }, 1000); // Wait for the fade-out animation to finish (1s)
    });

    // Add event listener to "Login Here!" link
    const loginLink = document.querySelector('#loginLink');
    loginLink.addEventListener('click', function () {
        const registrationForm = document.querySelector('#registrationForm');
        registrationForm.style.display = 'none'; // Hide the registration form

        // Fade out left carousel and fade in right carousel
        leftCarousel.classList.add('fade-out');
        setTimeout(function () {
            leftCarousel.style.display = 'none'; // Hide left carousel after fade out
            rightCarousel.style.display = 'block'; // Show right carousel
            rightCarousel.classList.add('fade-in');
            rightCarousel.classList.remove('fade-out'); // Remove fade-out class

            // Show the login form
            const loginForm = document.querySelector('#loginForm');
            loginForm.style.display = 'block'; // Display login form
        }, 1000); // Wait for the fade-out animation to finish (1s)
    });
});

const username = 'lamuelbapilar';

window.onload = function () {
    loadRegions();
};

async function loadRegions() {
    const regionSelect = document.getElementById("region");
    const regionNameInput = document.getElementById("regionName");

    try {
        const response = await fetch(`http://api.geonames.org/childrenJSON?geonameId=1694008&username=${username}`);
        const regions = await response.json();
        console.log("Regions fetched: ", regions);

        regions.geonames.forEach(region => {
            let option = document.createElement("option");
            option.value = region.geonameId;
            option.text = region.name;
            regionSelect.appendChild(option);
        });

        regionSelect.addEventListener("change", function () {
            const selectedRegionName = regionSelect.options[regionSelect.selectedIndex].text;
            console.log("Selected region name: ", selectedRegionName);
            regionNameInput.value = selectedRegionName;
        });

    } catch (error) {
        console.error("Error fetching regions: ", error);
    }
}

async function loadProvinces() {
    const regionId = document.getElementById("region").value;
    const provinceSelect = document.getElementById("province");
    const provinceNameInput = document.getElementById("provinceName");
    provinceSelect.innerHTML = '<option value="" disabled selected>Select Province</option>';

    try {
        const response = await fetch(`http://api.geonames.org/childrenJSON?geonameId=${regionId}&username=${username}`);
        const provinces = await response.json();
        console.log("Provinces fetched: ", provinces);

        provinces.geonames.forEach(province => {
            let option = document.createElement("option");
            option.value = province.geonameId;
            option.text = province.name;
            provinceSelect.appendChild(option);
        });

        provinceSelect.addEventListener("change", function () {
            const selectedProvinceName = provinceSelect.options[provinceSelect.selectedIndex].text;
            console.log("Selected province name: ", selectedProvinceName);
            provinceNameInput.value = selectedProvinceName;
        });

    } catch (error) {
        console.error("Error fetching provinces: ", error);
    }
}

async function loadCities() {
    const provinceId = document.getElementById("province").value;
    const citySelect = document.getElementById("city");
    const cityNameInput = document.getElementById("cityName");
    citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';

    try {
        const response = await fetch(`http://api.geonames.org/childrenJSON?geonameId=${provinceId}&username=${username}`);
        const cities = await response.json();
        console.log("Cities fetched: ", cities);

        cities.geonames.forEach(city => {
            let option = document.createElement("option");
            option.value = city.geonameId;
            option.text = city.name;
            citySelect.appendChild(option);
        });

        citySelect.addEventListener("change", function () {
            const selectedCityName = citySelect.options[citySelect.selectedIndex].text;
            console.log("Selected city name: ", selectedCityName);
            cityNameInput.value = selectedCityName;
        });

    } catch (error) {
        console.error("Error fetching cities: ", error);
    }
}

async function loadBarangays() {
    const cityId = document.getElementById("city").value;
    const barangaySelect = document.getElementById("barangay");
    const barangayNameInput = document.getElementById("barangayName");
    barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

    try {
        const response = await fetch(`http://api.geonames.org/childrenJSON?geonameId=${cityId}&username=${username}`);
        const barangays = await response.json();
        console.log("Barangays fetched: ", barangays);

        barangays.geonames.forEach(barangay => {
            let option = document.createElement("option");
            option.value = barangay.geonameId;
            option.text = barangay.name;
            barangaySelect.appendChild(option);
        });

        barangaySelect.addEventListener("change", function () {
            const selectedBarangayName = barangaySelect.options[barangaySelect.selectedIndex].text;
            console.log("Selected barangay name: ", selectedBarangayName);
            barangayNameInput.value = selectedBarangayName;
        });

    } catch (error) {
        console.error("Error fetching barangays: ", error);
    }
}

