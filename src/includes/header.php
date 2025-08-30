<?php
require_once __DIR__ . '/init.php';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricultural Supply & Demand Analysis</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="main-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-leaf me-2"></i>AgriAnalytics
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'farmer'): ?>
                            <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'farmer-dashboard.php' ? 'active' : ''; ?>" href="farmer-dashboard.php">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'production.php' ? 'active' : ''; ?>" href="production.php">Production</a></li>
                        <?php elseif ($_SESSION['role'] === 'Wholesaler'): ?>
                            <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'wholesaler-dashboard.php' ? 'active' : ''; ?>" href="wholesaler-dashboard.php">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'market.php' ? 'active' : ''; ?>" href="market.php">Market</a></li>
                        <?php elseif ($_SESSION['role'] === 'Retailer'): ?>
                            <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'retailer-dashboard.php' ? 'active' : ''; ?>" href="retailer-dashboard.php">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'market.php' ? 'active' : ''; ?>" href="market.php">Market</a></li>
                        <?php endif; ?>
                        
                        <!-- Common navigation items for all logged-in users -->
                        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'delivery.php' ? 'active' : ''; ?>" href="delivery.php">Delivery</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'storage.php' ? 'active' : ''; ?>" href="storage.php">Storage</a></li>
                        <li class="nav-item"><a class="nav-link" href="handlers/auth_handler.php?action=logout">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'login.php' ? 'active' : ''; ?>" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'signup.php' ? 'active' : ''; ?>" href="signup.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
