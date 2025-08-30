// Product Management Functions
async function fetchProducts() {
    try {
        const response = await fetch('handlers/product_handler.php?action=getAll');
        const data = await response.json();
        if (data.success) {
            updateProductTable(data.data);
        } else {
            console.error('Error fetching products:', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function updateProductTable(products) {
    const tbody = document.querySelector('#products table tbody');
    if (!tbody) return;

    tbody.innerHTML = products.map(product => `
        <tr>
            <td>${product.product_id}</td>
            <td>${product.name}</td>
            <td>${product.type}</td>
            <td>${product.variety}</td>
            <td>${product.sowing_time}</td>
            <td>${product.transplanting_time}</td>
            <td>${product.harvest_time}</td>
            <td>${product.per_acre_seed_requirement}</td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editProduct(${product.product_id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.product_id})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

// Add Product Form Handler
document.getElementById('addProductForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        name: this.querySelector('[name="name"]').value,
        type: this.querySelector('[name="type"]').value,
        variety: this.querySelector('[name="variety"]').value,
        sowingTime: this.querySelector('[name="sowingTime"]').value,
        transplantingTime: this.querySelector('[name="transplantingTime"]').value,
        harvestTime: this.querySelector('[name="harvestTime"]').value,
        perAcreSeedRequirement: this.querySelector('[name="seedRequirement"]').value
    };

    try {
        const response = await fetch('handlers/product_handler.php?action=add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        if (data.success) {
            alert('Product added successfully');
            this.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
            modal.hide();
            fetchProducts(); // Refresh the product table
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while adding the product');
    }
});

// Initialize dashboard data
async function initializeDashboard() {
    try {
        const response = await fetch('handlers/product_handler.php?action=getAll');
        const data = await response.json();
        if (data.success) {
            updateDashboardStats(data.data);
        }
    } catch (error) {
        console.error('Error initializing dashboard:', error);
    }
}

function updateDashboardStats(products) {
    // Update total products count
    const totalProductsElement = document.querySelector('.dashboard-section .card-text');
    if (totalProductsElement) {
        totalProductsElement.textContent = products.length;
    }

    // Update charts
    updateProductCharts(products);
}

// Load initial data when page loads
document.addEventListener('DOMContentLoaded', function() {
    fetchProducts();
    initializeDashboard();
});

// Edit Product Function
async function editProduct(productId) {
    try {
        const response = await fetch(`handlers/product_handler.php?action=get&productId=${productId}`);
        const data = await response.json();
        if (data.success) {
            // Populate edit form with product data
            const product = data.data;
            document.getElementById('editProductId').value = product.product_id;
            document.getElementById('editProductName').value = product.name;
            document.getElementById('editProductType').value = product.type;
            document.getElementById('editProductVariety').value = product.variety;
            // Show edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error fetching product details');
    }
}

// Delete Product Function
async function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        try {
            const response = await fetch('handlers/product_handler.php?action=delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ productId })
            });

            const data = await response.json();
            if (data.success) {
                alert('Product deleted successfully');
                fetchProducts(); // Refresh the product table
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the product');
        }
    }
}
