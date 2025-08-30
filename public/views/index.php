<?php
// Initialize session
session_start();

// Set base path for assets
$BASE_URL = '/Demand-And-Supply-Analysis-for-Agricultural-product';
$ASSETS_URL = $BASE_URL . '/public/assets';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricultural Demand and Supply Analysis</title>
    <link rel="stylesheet" href="<?php echo $ASSETS_URL; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="<?php echo $BASE_URL; ?>">
                    <i class="fas fa-leaf me-2"></i>AgriAnalytics
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/dashboard">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/products">Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/warehouses">Warehouses</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/market">Market Analysis</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/profile">Profile</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/logout">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/auth/login">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $BASE_URL; ?>/auth/signup">Sign Up</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Rest of your HTML content -->

    <!-- Required Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo $ASSETS_URL; ?>/js/main.js"></script>
    <script src="<?php echo $ASSETS_URL; ?>/js/api.js"></script>
</body>
</html>
