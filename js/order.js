//Buyer Custom JS

// Function to fetch orders
function fetchOrders() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/fetchorders.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const ordersElement = document.getElementById('orders');
            if (ordersElement) {
                ordersElement.innerHTML = xhr.responseText;
            }
        }
    };
    xhr.send();
}

// Search Order Function

function searchOrder(query) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/searchorder.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('orders').innerHTML = xhr.responseText;
        } else {
            console.error("Failed to fetch search results:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Request failed.");
    };
    xhr.send();
}

// Add Event Listener to Search order input
document.getElementById('search_order').addEventListener('input', function(event) {
    const query = event.target.value;
    searchOrder(query);
});

// js to upload to updateorder.php for confirmed order button

document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all forms
    document.querySelectorAll('.order-form').forEach(form => {
        form.addEventListener('submit', updateOrder);
    });

    // Fetch orders on page load
    fetchOrders();
});

function updateOrder(event) {
    event.preventDefault(); // Prevent the default form submission

    const form = event.target;
    const formData = new FormData(form);

    fetch('backend/updateorder.php', {
        method: 'POST',
        body: formData
    })
    .then(fetchOrders); // Refresh the orders
}

// Function to update the order status to 'delivered'
function orderDelivered(orderId) {
    const formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('order_status', 'delivered');

    fetch('backend/updateorderstatus.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Get raw response text
    .then(text => {
        try {
            const data = JSON.parse(text); // Parse JSON
            if (data.status === 'success') {
                fetchOrders(); // Refresh the orders
            } else {
                console.error('Error updating order status:', data.message);
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
            console.error('Response text:', text); // Log raw response text
        }
    })
    .catch(error => console.error('Error:', error));
}

// Function to delete an order
function deleteOrder(orderId) {
    if (confirm('Are you sure you want to delete this order?')) {
        const formData = new FormData();
        formData.append('order_id', orderId);

        fetch('backend/deleteorder.php', {
            method: 'POST',
            body: formData
        })
        .then(fetchOrders); // Refresh the orders
    }
}

// Function to cancel an order
function cancelOrder(orderId) {
    if (confirm('Are you sure you want to cancel this order?')) {
        const formData = new FormData();
        formData.append('order_id', orderId);

        fetch('backend/cancelorder.php', {
            method: 'POST',
            body: formData
        })
        .then(fetchOrders); // Refresh the orders
    }
}


// Open the review product modal
function openmyReviewProduct(productId) {
    document.getElementById('review-product-modal').style.display = 'flex';
    document.getElementById('product_id').value = productId;
    console.log("Product_id: " + productId);
}

// Close the review product modal
function closemyReviewProduct(event) {
    if (event && event.target.classList.contains('reviewmodal')) {
        return;  
    }

    const addProductModal = document.getElementById('review-product-modal');
    if (addProductModal) {
        addProductModal.style.display = 'none';
    } else {
        console.error("Add product modal not found.");
    }
    console.log("Add product modal closed.");
    // Fetch and display products when the page loads
    fetchOrders()
}


// Button to submit reviews

function reviewProduct() {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(document.getElementById("reportform"));

    fetch("backend/review.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Thank you for your review!");
            document.getElementById("reportform").reset(); // Reset form after submission
            fetchOrders(); // Refresh the orders
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while submitting the review.");
    });
}
