

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


// Add event listener to the search marketplace textarea
document.addEventListener('DOMContentLoaded', function() {
    const searchMarketplace = document.getElementById('search_marketplace');
    if (searchMarketplace) {
        searchMarketplace.addEventListener('input', function(event) {
            const query = event.target.value;
            searchProduct(query);
            console.log("Searching for products with query:", query);
        });
    } else {
        console.error("Element with ID 'search_marketplace' not found.");
    }
});

// Function to search and display products based on the query
function searchProduct(query) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/searchproduct.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const productsElement = document.getElementById('product');
            if (productsElement) {
                productsElement.innerHTML = xhr.responseText;
            } else {
                console.error("Element with ID 'products' not found.");
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



// Open the review product modal
function openReviewProduct(product_id) {
    console.log("Fetching reviews for product_id:", product_id);

    let modal = document.getElementById("review-product-modal");
    if (!modal) {
        console.error("Error: 'review-product-modal' not found.");
        return;
    }

    modal.style.display = "flex"; // Show modal

    let commentSection = document.getElementById("comment-section");
    if (!commentSection) {
        console.error("Error: 'comment-section' not found in the modal.");
        return;
    }

    fetch(`backend/fetchreviews.php?product_id=${product_id}`)
    .then(response => response.text())
    .then(data => {
        console.log("Fetched Reviews (Raw):", data); // ✅ Log the HTML to Console

        commentSection.innerHTML = data; // Insert reviews

        console.log("Updated comment-section:", commentSection.innerHTML); // ✅ Log to check inserted content
    })
    .catch(error => {
        console.error("Error fetching reviews:", error);
    });
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

// Open the report product modal
function openReportProduct(userId, productId, reporterusername, reportedusername) {
    document.getElementById('report-product-modal').style.display = 'flex';
    const reportModal = document.getElementById('report-product-modal');
    if (reportModal) {
        // Set the product ID, user ID, reporter username, and reported username in the modal
        document.getElementById('reported_user_id').value = userId;
        document.getElementById('product_id').value = productId;
        document.getElementById('reporter_username').value = reporterusername;
        document.getElementById('reported_username').value = reportedusername;
        reportModal.style.display = 'flex';
        console.log(userId, productId, reporterusername, reportedusername);
    } else {
        console.error("Report product modal not found.");
    }
}

// Close the report product modal
function closeReportProduct(event) {
    if (event && event.target.classList.contains('reportmodal')) {
        return;  
    }

    const addProductModal = document.getElementById('report-product-modal');
    if (addProductModal) {
        addProductModal.style.display = 'none';
    } else {
        console.error("Add product modal not found.");
    }
    console.log("report product modal closed.");
    // Fetch and display products when the page loads
    fetchProducts();
}


function reportProduct(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Front-end validation (if needed)
    if (!document.getElementById("report_issue").value || !document.getElementById("report_description").value) {
        alert("Please fill in all required fields.");
        return;
    }

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
            fetchProducts(); // Refresh products or do something after successful report
        }
    })
    .catch(error => console.error("Error:", error));
}


// Update modal button

function openUpdateProduct(product_id, product_title, product_content, product_price) {
    document.getElementById('update-product-modal').style.display = 'flex';
    
    // Ensure all elements exist before assigning values
    document.getElementById('update_product_id').value = product_id;
    document.getElementById('update_title').value = product_title;
    document.getElementById('update_content').value = product_content;
    document.getElementById('update_price').value = product_price;
    
    console.log(product_id, product_title, product_content, product_price);
}

function closeUpdateProduct(event){
    if (event && event.target.classList.contains('updatemodal')) {
        return;  
    }

    const addProductModal = document.getElementById('update-product-modal');
    if (addProductModal) {
        addProductModal.style.display = 'none';
    } else {
        console.error("Add product modal not found.");
    }
    console.log("update product modal closed.");
    // Fetch and display products when the page loads
}

function updateProduct(){
    let form = document.getElementById("updateform");
    let formData = new FormData(form);

    fetch("backend/updateproduct.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Show success or error message
        if (data.success) {
            fetchProducts();
        }
    })
    .catch(error => console.error("Error:", error));
}

