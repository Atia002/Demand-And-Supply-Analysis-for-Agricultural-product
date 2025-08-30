<?php
require_once 'includes/init.php';
include 'includes/header.php';
?>

<main class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">Agricultural Supply & Demand Analysis</h1>
        <p class="lead">Welcome to the comprehensive agricultural supply and demand management system.</p>
        <hr class="my-4">
        <?php if(!isset($_SESSION['user_id'])): ?>
            <p>Please login or sign up to access the system.</p>
            <div class="mt-4">
                <a href="login.php" class="btn btn-primary btn-lg mr-3">Login</a>
                <a href="signup.php" class="btn btn-success btn-lg">Sign Up</a>
            </div>
        <?php else: ?>
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Market Analysis</h5>
                            <p class="card-text">View and analyze market trends and prices.</p>
                            <a href="market.php" class="btn btn-primary">Go to Market</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Delivery Management</h5>
                            <p class="card-text">Manage product deliveries and tracking.</p>
                            <a href="delivery.php" class="btn btn-primary">Manage Deliveries</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Storage Management</h5>
                            <p class="card-text">Monitor and manage storage facilities.</p>
                            <a href="storage.php" class="btn btn-primary">Manage Storage</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
