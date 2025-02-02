
const decrement = document.getElementById('decrement');
const increment = document.getElementById('increment');
const counterValue = document.getElementById('counterValue');
var already_clicked = false;


decrement.addEventListener('click', (event) => {
  event.preventDefault(); // Prevent default button behavior
  const currentValue = parseInt(counterValue.value, 10);
  if (currentValue > 1) {
    counterValue.value = currentValue - 1;
  }
});

increment.addEventListener('click', (event) => {
  event.preventDefault(); // Prevent default button behavior
  const currentValue = parseInt(counterValue.value, 10);
  counterValue.value = currentValue + 1;
});

function popup_logout(){
  var popup = document.getElementById("dropdown-content");

  if(already_clicked){
    popup.style.display = "none";
    already_clicked = false;
  } else {
    popup.style.display = "block";
    already_clicked = true;
  }
}








// Function to fetch posts

// Function to fetch posts
function fetchPosts() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/fetchposts.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('post').innerHTML = xhr.responseText;
            console.log("Posts fetched successfully.");
        } else {
            console.error("Failed to fetch posts:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Request failed.");
    };
    xhr.send();
}



//Post Buttons JS

function buttondeletepost(postId) {
  if (confirm("Are you sure you want to delete this post?")) {
      var formData = new FormData();
      formData.append("post_id", postId);

      fetch("backend/deletepost.php", {
          method: "POST",
          body: formData
      })
      .then(response => response.text())
      .then(data => {
          alert(data); // Show a success message (optional)
          window.location.reload();
      })
      .catch(error => {
          console.error("Error:", error);
          alert("An error occurred while deleting the post.");
      });
  }
}


// Like Button JS

function toggleLike(postId) {
  const likeButton = document.getElementById('like-button-' + postId);
  let likeCountSpan = document.getElementById('like-count-' + postId);

  if (!likeButton || !likeCountSpan) {
    console.error("Like button or like count span not found for post:", postId);
    return;
  }

  const isLiked = likeButton.classList.contains('liked');
  const action = isLiked ? 'unlike' : 'like';

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'backend/Likes.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
    if (xhr.status === 200) {
      try {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          // Only update the like count text without replacing the entire span
          likeCountSpan.textContent = response.new_like_count;

          // Toggle the button text and class
          if (action === 'like') {
            likeButton.classList.add('liked');
            likeButton.textContent = 'Unlike';
          } else {
            likeButton.classList.remove('liked');
            likeButton.textContent = 'Like';
          }
        } else {
          alert('Error toggling like');
        }
      } catch (error) {
        console.error("Error parsing JSON response:", error, xhr.responseText);
      }
    }
  };

  const data = `post_id=${postId}&action=${action}`;
  xhr.send(data);
}


// Follow/Unfollow Button JS


// Function to toggle follow/unfollow status and fetch posts

function toggleFollow(userId, followerId, postId) {
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
    
                    fetchPosts();
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




// This section is for the js of comments


 // Function to open the Comment modal  
 function openComment(post_id) {
  // Set the post_id in the hidden input
  document.getElementById('post_id').value = post_id;

  console.log("Opening comments for Post ID: " + post_id); // Debugging line

  // Open the modal
  const commentModal = document.getElementById('comment-modal');
  if (commentModal) {
      commentModal.style.display = 'flex';
  } else {
      console.error("Comment modal not found.");
  }

  // Fetch comments from fetchcomments.php
  fetch('backend/fetchcomments.php?post_id=' + post_id)
      .then(response => response.text())
      .then(data => {
          // Inject the fetched comments into the modal
          const commentSection = document.querySelector('.comment-section');
          if (commentSection) {
              commentSection.innerHTML = data; // Insert the comments into the modal
          }
      })
      .catch(error => {
          console.error('Error fetching comments:', error);
      });
}




// Function to close the modal  
function closeComment(event) {
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
    fetchPosts();
}



function submitComment(event) {
  event.preventDefault(); // Prevent default form submission behavior

  const form = document.getElementById('commentForm');
  const postId = document.getElementById('post_id').value; // Get post_id from the hidden input

  const formData = new FormData(form);

  fetch('backend/comment.php', {
      method: 'POST',
      body: formData, // Automatically encodes the data
  })
      .then((response) => {
          if (!response.ok) {
              throw new Error(`Network error: ${response.status} ${response.statusText}`);
          }
          return response.json(); // Parse the JSON response
      })
      .then((data) => {
          if (data.success) {
              // Display success message
              alert(data.message);
              // Clear the comment box
              document.getElementById('comment_content').value = '';

              // Fetch and update the comments section
              fetchComments(postId);
          } else {
              // Display the error message from the server
              alert(`Error: ${data.message}`);
          }
      })
      .catch((error) => {
          // Handle any other errors
          console.error('Error:', error);
          alert('An error occurred while submitting your comment. Please try again.');
      });
}

// Function to fetch and update the comments
function fetchComments(postId) {
  fetch('backend/fetchcomments.php?post_id=' + postId)
      .then(response => response.text())
      .then(data => {
          // Inject the fetched comments into the modal
          const commentSection = document.querySelector('.comment-section');
          if (commentSection) {
              commentSection.innerHTML = data; // Insert the comments into the modal
          }
      })
      .catch(error => {
          console.error('Error fetching comments:', error);
      });
}


// to like a comment function

function toggleCommentLike(commentId) {
  const likeButton = document.getElementById('comment-like-' + commentId);
  const likeCountSpan = document.getElementById('comment-like-count-' + commentId);

  // Check if the button is already liked
  const isLiked = likeButton.classList.contains('liked');
  const action = isLiked ? 'unlike' : 'like';

  // Make an AJAX request to toggle like/unlike
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'backend/commentlikes.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
  xhr.onload = function() {
      if (xhr.status === 200) {
          try {
              const response = JSON.parse(xhr.responseText);
              if (response.success) {
                  // Update the like count
                  likeCountSpan.textContent = response.new_like_count;

                  // Toggle the button's state
                  if (action === 'like') {
                      likeButton.classList.add('liked');
                      likeButton.textContent = 'Unlike';
                  } else {
                      likeButton.classList.remove('liked');
                      likeButton.textContent = 'Like';
                  }
              } else {
                  alert('Error toggling like');
              }
          } catch (error) {
              console.error("Error parsing JSON response:", error);
          }
      }
  };

  const data = `comment_id=${commentId}&action=${action}`;
  xhr.send(data);
}



// Open the report post modal

function openReportPost(userId, postId, reporterusername, reportedusername) {
    document.getElementById('report-post-modal').style.display = 'flex';
    const reportModal = document.getElementById('report-post-modal');
    if (reportModal) {
        // Set the product ID, user ID, reporter username, and reported username in the modal
        document.getElementById('reported_user_id').value = userId;
        document.getElementById('product_id').value = postId; // Ensure this is correctly assigned
        document.getElementById('reporter_username').value = reporterusername;
        document.getElementById('reported_username').value = reportedusername;
        
        console.log("User ID:", userId, "Post ID:", postId, "Reporter Username:", reporterusername, "Reported Username:", reportedusername);
        console.log("Post ID input value:", document.getElementById('post_id').value);  // Check if the value is correctly assigned
    } else {
        console.error("Report product modal not found.");
    }
}


// Close the report product modal
function closeReportPost(event) {
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



function reportPost() {
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