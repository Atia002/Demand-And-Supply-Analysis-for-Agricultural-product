<?php
require_once 'config/db_connect.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get user role and information
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

// Get farmer information if user is a farmer
$farmerInfo = null;
if ($userRole === 'farmer') {
    $stmt = $conn->prepare("SELECT * FROM farmer WHERE farmer_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $farmerInfo = $stmt->get_result()->fetch_assoc();
}

// Get farm information
$farms = array();
if ($farmerInfo) {
    $stmt = $conn->prepare("SELECT * FROM farm WHERE farmer_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $farms[] = $row;
    }
}

// Get production information
$productions = array();
if ($farmerInfo) {
    $stmt = $conn->prepare("SELECT p.*, pr.name as product_name 
                           FROM production p 
                           JOIN product pr ON p.product_id = pr.product_id 
                           WHERE p.farmer_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $productions[] = $row;
    }
}

// Close database connection
$conn->close();
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
                    <form id="addFarmForm">
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
                    <form id="addProductionForm">
                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select class="form-select" name="product_id" required>
                                <!-- Products will be loaded dynamically -->
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
