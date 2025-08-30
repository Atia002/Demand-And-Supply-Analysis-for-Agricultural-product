<?php
require_once 'config/db_connect.php';
include 'includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get storage locations
$stmt = $conn->prepare("SELECT * FROM storage ORDER BY address");
$stmt->execute();
$storages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Storage Management</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStorageModal">
            <i class="fas fa-plus"></i> New Storage Location
        </button>
    </div>

    <!-- Storage List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Capacity (tons)</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($storages as $storage): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($storage['storage_id']); ?></td>
                            <td><?php echo htmlspecialchars($storage['address']); ?></td>
                            <td><?php echo htmlspecialchars($storage['capacity']); ?></td>
                            <td><?php echo htmlspecialchars($storage['type']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editStorage(<?php echo $storage['storage_id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteStorage(<?php echo $storage['storage_id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Add Storage Modal -->
<div class="modal fade" id="addStorageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Storage Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addStorageForm">
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Capacity (tons)</label>
                        <input type="number" step="0.01" class="form-control" name="capacity" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" required>
                            <option value="Cold Storage">Cold Storage</option>
                            <option value="Dry Storage">Dry Storage</option>
                            <option value="Warehouse">Warehouse</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addStorageForm" class="btn btn-primary">Add Storage</button>
            </div>
        </div>
    </div>
</div>

<script>
// Form submission handler
document.getElementById('addStorageForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('handlers/storage_handler.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Storage location added successfully');
            location.reload();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while adding the storage location');
    }
});

// Delete storage function
async function deleteStorage(storageId) {
    if (!confirm('Are you sure you want to delete this storage location?')) return;
    
    try {
        const response = await fetch('handlers/storage_handler.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ storage_id: storageId })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Storage location deleted successfully');
            location.reload();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the storage location');
    }
}

// Edit storage function
async function editStorage(storageId) {
    // Implementation for editing storage
    console.log('Edit storage:', storageId);
    // Add your edit implementation here
}
</script>

<?php include 'includes/footer.php'; ?>
