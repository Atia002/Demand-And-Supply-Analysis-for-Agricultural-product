<?php
// Start the session
session_start();

// Check if user is logged in and is a farmer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header('Location: login.php');
    exit();
}

// Get user information
$userId = $_SESSION['user_id'];

// Include database connection
require_once 'db.php';

// $conn is initialized in db.php, if there was an error, 
// the script would have already redirected to error.php

try {
    if (!$conn) {
        throw new Exception("Database connection not available");
    }

    // Get farmer information
    $query = "SELECT * FROM farmer WHERE farmer_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    if (!$stmt->bind_param("i", $userId)) {
        throw new Exception("Binding parameters failed: " . $stmt->error);
    }
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $farmerResult = $stmt->get_result();
    if (!$farmerResult) {
        throw new Exception("Failed to get farmer result");
    }
    
    $farmerInfo = $farmerResult->fetch_assoc();
    $stmt->close();

    if (!$farmerInfo) {
        throw new Exception("Farmer information not found");
    }

    // Get farm information
    $farms = array();
    $query = "SELECT * FROM farm WHERE farmer_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    if (!$stmt->bind_param("i", $userId)) {
        throw new Exception("Binding parameters failed: " . $stmt->error);
    }
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $farmResult = $stmt->get_result();
    if (!$farmResult) {
        throw new Exception("Failed to get farm result");
    }
    
    while ($row = $farmResult->fetch_assoc()) {
        $farms[] = $row;
    }
    $stmt->close();

    // Get production information
    $productions = array();
    $query = "SELECT p.*, pr.name as product_name 
              FROM production p 
              JOIN product pr ON p.product_id = pr.product_id 
              WHERE p.farmer_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    if (!$stmt->bind_param("i", $userId)) {
        throw new Exception("Binding parameters failed: " . $stmt->error);
    }
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $productionResult = $stmt->get_result();
    if (!$productionResult) {
        throw new Exception("Failed to get production result");
    }
    
    while ($row = $productionResult->fetch_assoc()) {
        $productions[] = $row;
    }
    $stmt->close();

} catch (Exception $e) {
    // Log the error and show user-friendly message
    error_log("Error in farmer-dashboard.php: " . $e->getMessage());
    $_SESSION['error_message'] = "An error occurred while loading the dashboard. Please try again later.";
    header('Location: error.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container mt-4">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo htmlspecialchars($_SESSION['success_message']); 
                    unset($_SESSION['success_message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo htmlspecialchars($_SESSION['error_message']); 
                    unset($_SESSION['error_message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <h1>Welcome, <?php echo htmlspecialchars($farmerInfo['name']); ?></h1>
        
        <!-- Farmer Information -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Farmer Information</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($farmerInfo['name']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($farmerInfo['address']); ?></p>
                        <p><strong>Contact:</strong> <?php echo htmlspecialchars($farmerInfo['contact']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Experience:</strong> <?php echo htmlspecialchars($farmerInfo['year_of_experience']); ?> years</p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($farmerInfo['gender']); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Farms Section -->
        <section class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>My Farms</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFarmModal">
                    <i class="fas fa-plus"></i> Add Farm
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Farm ID</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($farms as $farm): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($farm['farm_id']); ?></td>
                                <td><?php echo htmlspecialchars($farm['address']); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editFarm(<?php echo $farm['farm_id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteFarm(<?php echo $farm['farm_id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Production Section -->
        <section class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Production Records</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductionModal">
                    <i class="fas fa-plus"></i> Add Production
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Batch No</th>
                                <th>Product</th>
                                <th>Year</th>
                                <th>Season</th>
                                <th>Acreage</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productions as $production): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($production['batch_no']); ?></td>
                                <td><?php echo htmlspecialchars($production['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($production['year']); ?></td>
                                <td><?php echo htmlspecialchars($production['season']); ?></td>
                                <td><?php echo htmlspecialchars($production['acre_age']); ?></td>
                                <td><?php echo htmlspecialchars($production['quantity']); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editProduction('<?php echo $production['batch_no']; ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduction('<?php echo $production['batch_no']; ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- Add Farm Modal -->
    <div class="modal fade" id="addFarmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Farm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addFarmForm" action="handlers/farmer_handler.php" method="POST">
                        <input type="hidden" name="action" value="add_farm">
                        <div class="mb-3">
                            <label class="form-label">Farm Address</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addFarmForm" class="btn btn-primary">Add Farm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Production Modal -->
    <div class="modal fade" id="addProductionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Production Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductionForm" action="handlers/farmer_handler.php" method="POST">
                        <input type="hidden" name="action" value="add_production">
                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select class="form-select" name="product_id" required>
                                <!-- Products will be loaded dynamically via JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year</label>
                            <input type="number" class="form-control" name="year" required min="2000" max="2100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Season</label>
                            <select class="form-select" name="season" required>
                                <option value="Rabi">Rabi</option>
                                <option value="Kharif">Kharif</option>
                                <option value="Zaid">Zaid</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Acreage</label>
                            <input type="number" class="form-control" name="acre_age" required step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity (in tons)</label>
                            <input type="number" class="form-control" name="quantity" required step="0.01">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addProductionForm" class="btn btn-primary">Add Production</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/farmer-dashboard.js"></script>
</body>
</html>
<?php 
// Close the database connection if it exists
if ($conn) {
    $conn->close();
}
?>
