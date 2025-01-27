
// Function to fetch and display user's following posts

function fetchFollowing() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/fetchfollowingposts.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const followingPostsElement = document.getElementById('following');
            if (followingPostsElement) {
                followingPostsElement.innerHTML = xhr.responseText;
                console.log("Following posts fetched successfully.");
            } else {
                console.error("Element with ID 'following-posts' not found.");
            }
        } else {
            console.error("Failed to fetch following posts:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Request failed.");
    };
    xhr.send();
}


// Custom Following Post Buttons Here:

// Follow/Unfollow Button JS


function toggleFollowing(userId, followerId, postId) {
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
