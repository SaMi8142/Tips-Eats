

// Function to fetch and display products
function fetchProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/fetchproducts.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const myPostsElement = document.getElementById('product');
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





// Add Product Modal Section






// Open the add product modal
function openAddProduct() {
    document.getElementById('add-product-modal').style.display = 'flex';
}

// Close the add product modal
function closeAddProduct(event) {
    if (event && event.target.classList.contains('add-product-body')) {
        return;  
    }

    const addProductModal = document.getElementById('add-product-modal');
    if (addProductModal) {
        addProductModal.style.display = 'none';
    } else {
        console.error("Add product modal not found.");
    }
    console.log("Add product modal closed.");
    // Fetch and display products when the page loads
    fetchProducts();
}

// Display the file name for <input type="file">
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('product_pic');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    } else {
        console.error("File input not found.");
    }

});

// custom buttons for the products

// Function to delete a product


function deleteProduct(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
        fetch('backend/deleteproduct.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + encodeURIComponent(productId)
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            // Fetch and display products when the page loads
              fetchProducts();
        })
        .catch(error => {
            console.error('Error deleting product:', error);
        });
    }
}

// Function to place an order button 
function orderProduct(seller_id, product_id) {
    const order_quantity = 1;

    const data = new URLSearchParams();
    data.append('product_id', product_id);
    data.append('seller_id', seller_id);
    data.append('order_quantity', order_quantity);

    fetch('backend/order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data.toString()
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        fetchProducts(); // Refresh the products
    })
    .catch(error => {
        console.error('Error placing order:', error);
    });
}



// Review Modal Section





// Open the review product modal
function openReviewProduct() {
    document.getElementById('review-product-modal').style.display = 'flex';
}

// Close the review product modal
function closeReviewProduct(event) {
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
    fetchProducts();
}