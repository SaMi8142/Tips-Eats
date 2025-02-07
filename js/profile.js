document.getElementById('profile_profile_pic').addEventListener('change', function(e) {
    const fileName = e.target.files[0].name;
    document.getElementById('profile_profile_name').textContent = fileName;
});

// Open the Update profile modal

function openUpdateProfile() {
    document.getElementById('report-post-modal').style.display = 'flex';
    const reportModal = document.getElementById('update-profile-modal');
    if (reportModal) {

        console.log("Modal Opened ");  // Check if the value is correctly assigned
    } else {
        console.error("Report product modal not found.");
    }
}


// Close the report product modal
function closeUpdateProfile(event) {
    if (event && event.target.classList.contains('Profilemodal')) {
        return;  
    }

    const addProductModal = document.getElementById('report-post-modal');
    if (addProductModal) {
        addProductModal.style.display = 'none';
    } else {
        console.error("report post modal not found.");
    }
    console.log("report product modal closed.");
    // Fetch and display post when the page loads
}



function updateProfile() {
    

    // Get the form element and create a new FormData object
    let form = document.getElementById("productform");
    let formData = new FormData(form);

    // Log the entire form data
    console.log("Form Data being sent:");
    formData.forEach((value, key) => {
        console.log(key + ": " + value); // Log each form field key-value pair
    });
}


