<?php
require_once 'db.php';
session_start();

if (!$conn || !($conn instanceof mysqli)) {
    die("Database connection failed.");
}

// Check if user is logged in and is a wholesaler
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Wholesaler') {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Get wholesaler information
$stmt = $conn->prepare("SELECT * FROM vendor v 
                       JOIN wholesaler w ON v.license_id = w.license_id 
                       WHERE v.license_id = ?");
$stmt->bind_param("s", $userId);
$stmt->execute();
$wholesalerInfo = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesaler Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container mt-4">
        <h1>Welcome, <?php echo htmlspecialchars($wholesalerInfo['name']); ?></h1>
        
        <!-- Wholesaler Information -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Wholesaler Information</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>License ID:</strong> <?php echo htmlspecialchars($wholesalerInfo['license_id']); ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($wholesalerInfo['name']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($wholesalerInfo['address']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($wholesalerInfo['reg_date']); ?></p>
                        <p><strong>Min Order Quantity:</strong> <?php echo htmlspecialchars($wholesalerInfo['min_order_quantity']); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Market Analysis Section -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Market Analysis</h2>
            </div>
            <div class="card-body">
                <!-- Add market analysis content -->
            </div>
        </section>

        <!-- Storage Management -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Storage Management</h2>
            </div>
            <div class="card-body">
                <!-- Add storage management content -->
            </div>
        </section>

        <!-- Delivery Management -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Delivery Management</h2>
            </div>
            <div class="card-body">
                <!-- Add delivery management content -->
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/wholesaler-dashboard.js"></script>
</body>
</html>
