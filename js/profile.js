// Open the Update profile modal

function openUpdateProfile() {
    document.getElementById('report-post-modal').style.display = 'flex';
    const reportModal = document.getElementById('update-profile-modal');
    if (reportModal) {

        console.log("Post ID input value:", document.getElementById('post_id').value);  // Check if the value is correctly assigned
    } else {
        console.error("Report product modal not found.");
    }
}


// Close the report product modal
function closeUpdateProfile(event) {
    if (event && event.target.classList.contains('reportmodal')) {
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
    fetchPosts();
}



function updateProfile() {
    let form = document.getElementById("reportform");
    let formData = new FormData(form);

    fetch("backend/reportpost.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Show success or error message
        if (data.success) {
            fetchPosts();
        }
    })
    .catch(error => console.error("Error:", error));
}