// This JS is dedicated for the My Posts and fetchmyposts.php

// Function to fetch and display user's own posts
function fetchmPosts() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/fetchmyposts.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const myPostsElement = document.getElementById('post');
            if (myPostsElement) {
                myPostsElement.innerHTML = xhr.responseText;
                console.log("My posts fetched successfully.");
            } else {
                console.error("Element with ID 'my-posts' not found.");
            }
        } else {
            console.error("Failed to fetch my posts:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Request failed.");
    };
    xhr.send();
}


// Custom Following Post Buttons Here:

// Follow/Unfollow Button JS


function togglemFollow(userId, followerId, postId) {
    const followButton = document.getElementById('follow-button-' + postId);
  
    if (!followButton) {
        console.error("Follow button not found for user:", userId);
        return;
    }
  
    const isFollowing = followButton.classList.contains('following');
    const action = isFollowing ? 'unfollow' : 'follow';
  
    // Debug: Log action and IDs
    console.log(`Action: ${action}, User ID: ${userId}, Follower ID: ${followerId}`);
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'backend/follow.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                console.log("XHR response: ", response);
  
                if (response.success) {
                    // Toggle the button text and class
                    if (action === 'follow') {
                        followButton.classList.add('following');
                        followButton.textContent = 'Unfollow';
                    } else if (action === 'unfollow') {
                        followButton.classList.remove('following');
                        followButton.textContent = 'Follow';
                    }
    
                    fetchmPosts();
                } else {
                    console.error("Error from server:", response.error);
                    alert('Error toggling follow. Please try again.');
                }
            } catch (error) {
                console.error("Error parsing JSON response:", error, xhr.responseText);
                alert('Unexpected error. Please try again.');
            }
        } 
    };
  
    const data = `user_id=${userId}&follower_id=${followerId}&action=${action}`;
    xhr.send(data);
}



// Function to close the modal  
function closemComment(event) {
    // Prevent closing the modal if the user clicked inside the modal body
    if (event && event.target.classList.contains('comment-body')) {
        return;  // Don't close the modal if clicked inside the comment body
    }

    // Hide the modal by changing its display property
    const commentModal = document.getElementById('comment-modal');
    if (commentModal) {
        commentModal.style.display = 'none';
             
    } else {
        console.error("Comment modal not found.");
    }

    // Optionally clear the input field when closing
    const postIdInput = document.getElementById('post_id');
    if (postIdInput) {
        postIdInput.value = '';  // Clear the post_id value when closing
    }
    // Log to confirm closing
    console.log("Modal closed.");
    fetchmPosts();
}