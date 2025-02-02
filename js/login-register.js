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


