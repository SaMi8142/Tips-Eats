
// Function to fetch and display user's following posts

function fetchFollowing() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/fetchfollowing.php', true);
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


//searchbar JS for the following here 

// Search Following Function
function searchFollowing(query) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/searchfollowing.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('following').innerHTML = xhr.responseText;
        } else {
            console.error("Failed to fetch search results:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Request failed.");
    };
    xhr.send();
}

// Add Event Listener for Search Input
document.getElementById('search_following').addEventListener('input', function(event) {
    const query = event.target.value;
    searchFollowing(query);
});



// Custom Following Post Buttons Here:

// Follow/Unfollow Button JS


function toggleFollowing(userId, followerId, postId) {
    const followButton = document.getElementById('follow-button-' + postId);
  
    if (!followButton) {
        console.error("Follow button not found for user:", userId);
        return;
    }
  
    const isFollowing = followButton.classList.contains('follower');
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
                        followButton.classList.remove('unfollower');
                        followButton.classList.add('follower');
                        followButton.textContent = 'Unfollow';
                    } else if (action === 'unfollow') {
                        followButton.classList.remove('follower');
                        followButton.classList.add('unfollower');
                        followButton.textContent = 'Follow';
                    }
          
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
