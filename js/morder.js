// Seller Custom JS


// Function to fetch product orders for the seller
function fetchMorders() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/fetchmorders.php', true);
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

// Function to update the seller status to 'approved'
function updatesellerApproved(orderId) {
    const formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('status', 'approved');

    fetch('backend/updatesellerstatus.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(fetchMorders); // Refresh the orders
}

// Function to update the seller status to 'rejected'
function updatesellerReject(orderId) {
    const formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('status', 'rejected');

    fetch('backend/updatesellerstatus.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(fetchMorders); // Refresh the orders
}


// Function to update the order status
function updateMorderStatus(event) {
    event.preventDefault(); // Prevent the default form submission

    const form = event.target;
    const formData = new FormData(form);

    fetch('backend/updateorderstatus.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            fetchMorders(); // Refresh the orders
        } else {
            console.error('Error updating order status:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}






// Function to search and display orders for the seller based on the query
function searchMorders(query) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/searchmorder.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const ordersElement = document.getElementById('orders');
            if (ordersElement) {
                ordersElement.innerHTML = xhr.responseText;
            }
        } else {
            console.error("Failed to fetch search results:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Request failed.");
    };
    xhr.send();
}

// Add event listener to search order input for the seller
document.getElementById('search_morder').addEventListener('input', function(event) {
    const query = event.target.value;
    searchMorders(query);
});

