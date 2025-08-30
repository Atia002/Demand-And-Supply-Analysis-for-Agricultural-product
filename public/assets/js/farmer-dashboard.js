// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Load products for the dropdown
    loadProducts();

    // Add event listeners for forms
    document.getElementById('addFarmForm')?.addEventListener('submit', handleAddFarm);
    document.getElementById('addProductionForm')?.addEventListener('submit', handleAddProduction);

    // Add event listeners for delete buttons
    document.querySelectorAll('.btn-delete-farm').forEach(btn => {
        btn.addEventListener('click', () => deleteFarm(btn.dataset.farmId));
    });

    document.querySelectorAll('.btn-delete-production').forEach(btn => {
        btn.addEventListener('click', () => deleteProduction(btn.dataset.batchNo));
    });
});

// Load products for the dropdown
function loadProducts() {
    fetch('handlers/farmer_handler.php?action=get_products')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.querySelector('select[name="product_id"]');
                if (select) {
                    data.data.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.product_id;
                        option.textContent = product.name;
                        select.appendChild(option);
                    });
                }
            }
        })
        .catch(error => console.error('Error loading products:', error));
}

// Handle adding a new farm
function handleAddFarm(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    formData.append('action', 'add_farm');

    fetch('handlers/farmer_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Refresh to show new farm
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error adding farm:', error));
}

// Handle adding a new production record
function handleAddProduction(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    formData.append('action', 'add_production');

    fetch('handlers/farmer_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Refresh to show new production record
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error adding production:', error));
}

// Delete a farm
function deleteFarm(farmId) {
    if (confirm('Are you sure you want to delete this farm?')) {
        const formData = new FormData();
        formData.append('action', 'delete_farm');
        formData.append('farm_id', farmId);

        fetch('handlers/farmer_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh to remove deleted farm
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error deleting farm:', error));
    }
}

// Delete a production record
function deleteProduction(batchNo) {
    if (confirm('Are you sure you want to delete this production record?')) {
        const formData = new FormData();
        formData.append('action', 'delete_production');
        formData.append('batch_no', batchNo);

        fetch('handlers/farmer_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh to remove deleted production
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error deleting production:', error));
    }
}
