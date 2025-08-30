<?php
require_once 'includes/init.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Try farmer login first
    $query = "SELECT farmer_id as id, name, 'farmer' as role, contact 
              FROM farmer 
              WHERE contact = :username AND password = :password";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);
    $user = $stmt->fetch();

    // If not found, try vendor login
    if (!$user) {
        $query = "SELECT v.license_id as id, v.name, v.vendor_type as role, v.contact
                  FROM vendor v 
                  WHERE v.license_id = :username AND v.password = :password";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password
        ]);
        $user = $stmt->fetch();
    }
    
    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['user_id'] = $user['farmer_id'] ?? $user['license_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect based on role
        switch($user['role']) {
            case 'farmer':
                header('Location: farmer-dashboard.php');
                break;
            case 'Wholesaler':
                header('Location: wholesaler-dashboard.php');
                break;
            case 'Retailer':
                header('Location: retailer-dashboard.php');
                break;
            default:
                header('Location: index.php');
        }
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agricultural Supply & Demand Analysis</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label class="form-label">Username/Contact</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>Don't have an account? 
                                <a href="signup.php">Sign Up</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
