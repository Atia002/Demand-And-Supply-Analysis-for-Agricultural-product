<?php
require_once 'config/db_connect.php';
include 'includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get delivery information
$stmt = $conn->prepare("
    SELECT d.*, 
           s1.address as from_address,
           s2.address as to_address,
           v.name as vendor_name,
           c.name as consumer_name
    FROM delivery d
    LEFT JOIN storage s1 ON d.from_storage_id = s1.storage_id
    LEFT JOIN storage s2 ON d.to_storage_id = s2.storage_id
    LEFT JOIN vendor v ON d.vendor_id = v.license_id
    LEFT JOIN consumer c ON d.consumer_id = c.consumer_id
    ORDER BY d.date DESC
");
$stmt->execute();
$deliveries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get storage locations for dropdowns
$stmt = $conn->prepare("SELECT * FROM storage ORDER BY address");
$stmt->execute();
$storages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get vendors for dropdown
$stmt = $conn->prepare("SELECT * FROM vendor ORDER BY name");
$stmt->execute();
$vendors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get consumers for dropdown
$stmt = $conn->prepare("SELECT * FROM consumer ORDER BY name");
$stmt->execute();
$consumers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Delivery Management</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeliveryModal">
            <i class="fas fa-plus"></i> New Delivery
        </button>
    </div>

    <!-- Delivery List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Delivery ID</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Transport Mode</th>
                            <th>Status</th>
                            <th>Vendor</th>
                            <th>Consumer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deliveries as $delivery): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($delivery['delivery_id']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['date']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['from_address']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['to_address']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['transport_mode']); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $delivery['status'] === 'Delivered' ? 'success' : 
                                        ($delivery['status'] === 'In Transit' ? 'warning' : 
                                        ($delivery['status'] === 'Cancelled' ? 'danger' : 'info')); 
                                ?>">
                                    <?php echo htmlspecialchars($delivery['status']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($delivery['vendor_name']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['consumer_name']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editDelivery(<?php echo $delivery['delivery_id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteDelivery(<?php echo $delivery['delivery_id']; ?>)">
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

<!-- Add Delivery Modal -->
<div class="modal fade" id="addDeliveryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Delivery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addDeliveryForm">
                    <div class="mb-3">
                        <label class="form-label">From Storage</label>
                        <select class="form-select" name="from_storage_id" required>
                            <option value="">Select Storage Location</option>
                            <?php foreach ($storages as $storage): ?>
                            <option value="<?php echo $storage['storage_id']; ?>">
                                <?php echo htmlspecialchars($storage['address']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">To Storage</label>
                        <select class="form-select" name="to_storage_id">
                            <option value="">Select Storage Location</option>
                            <?php foreach ($storages as $storage): ?>
                            <option value="<?php echo $storage['storage_id']; ?>">
                                <?php echo htmlspecialchars($storage['address']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Transport Mode</label>
                        <select class="form-select" name="transport_mode" required>
                            <option value="Road">Road</option>
                            <option value="Rail">Rail</option>
                            <option value="Air">Air</option>
                            <option value="Sea">Sea</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vendor</label>
                        <select class="form-select" name="vendor_id">
                            <option value="">Select Vendor</option>
                            <?php foreach ($vendors as $vendor): ?>
                            <option value="<?php echo $vendor['license_id']; ?>">
                                <?php echo htmlspecialchars($vendor['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Consumer</label>
                        <select class="form-select" name="consumer_id">
                            <option value="">Select Consumer</option>
                            <?php foreach ($consumers as $consumer): ?>
                            <option value="<?php echo $consumer['consumer_id']; ?>">
                                <?php echo htmlspecialchars($consumer['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addDeliveryForm" class="btn btn-primary">Add Delivery</button>
            </div>
        </div>
    </div>
</div>

<script>
// Form submission handler
document.getElementById('addDeliveryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('handlers/delivery_handler.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Delivery added successfully');
            location.reload();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while adding the delivery');
    }
});

// Delete delivery function
async function deleteDelivery(deliveryId) {
    if (!confirm('Are you sure you want to delete this delivery?')) return;
    
    try {
        const response = await fetch('handlers/delivery_handler.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ delivery_id: deliveryId })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Delivery deleted successfully');
            location.reload();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the delivery');
    }
}

// Edit delivery function
async function editDelivery(deliveryId) {
    // Implementation for editing delivery
    console.log('Edit delivery:', deliveryId);
    // Add your edit implementation here
}
</script>

<?php include 'includes/footer.php'; ?>
