<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center text-danger">Error</h3>
                        <div class="alert alert-danger">
                            <?php 
                            echo isset($_SESSION['error_message']) 
                                ? htmlspecialchars($_SESSION['error_message']) 
                                : 'An unexpected error occurred. Please try again later.';
                            
                            // Clear the error message
                            unset($_SESSION['error_message']);
                            ?>
                        </div>
                        <div class="text-center">
                            <a href="index.php" class="btn btn-primary">Return to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
