<?php
require_once 'db.php';
session_start();

// Check if user is logged in and is a retailer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Retailer') {
    header('Location: login.php');
    exit();
}

// Check if database connection is successful
if (!$conn || !($conn instanceof mysqli)) {
    die("Database connection failed.");
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Get retailer information
$stmt = $conn->prepare("SELECT * FROM vendor v 
                       JOIN retailer r ON v.license_id = r.license_id 
                       WHERE v.license_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $userId);
$stmt->execute();
$retailerInfo = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container mt-4">
        <h1>Welcome, <?php echo htmlspecialchars($retailerInfo['name']); ?></h1>
        
        <!-- Retailer Information -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Retailer Information</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>License ID:</strong> <?php echo htmlspecialchars($retailerInfo['license_id']); ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($retailerInfo['name']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($retailerInfo['address']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($retailerInfo['reg_date']); ?></p>
                        <p><strong>Store Type:</strong> <?php echo htmlspecialchars($retailerInfo['store_type']); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Market Prices -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Market Prices</h2>
            </div>
            <div class="card-body">
                <!-- Add market prices content -->
            </div>
        </section>

        <!-- Inventory Management -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Inventory Management</h2>
            </div>
            <div class="card-body">
                <!-- Add inventory management content -->
            </div>
        </section>

        <!-- Customer Orders -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Customer Orders</h2>
            </div>
            <div class="card-body">
                <!-- Add customer orders content -->
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/retailer-dashboard.js"></script>
</body>
</html>
