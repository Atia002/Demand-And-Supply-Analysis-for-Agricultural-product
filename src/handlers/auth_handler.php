<?php
require_once '../includes/init.php';
require_once('../config/db_connect.php');

header('Content-Type: application/json');

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password']; // In production, use password_hash() and password_verify()
    
    $query = "SELECT f.farmer_id as id, f.name, 'farmer' as role 
              FROM farmer f 
              WHERE f.contact = ? AND f.password = ?
              UNION
              SELECT v.license_id as id, v.name, v.vendor_type as role
              FROM vendor v
              WHERE v.contact = ? AND v.password = ?";
              
    try {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $username, $password, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            echo json_encode([
                'success' => true,
                'redirect' => $user['role'] === 'farmer' ? 'farmer-dashboard.php' : 
                            ($user['role'] === 'Wholesaler' ? 'wholesaler-dashboard.php' : 'retailer-dashboard.php')
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $data = $_POST;
    
    try {
        $conn->begin_transaction();
        
        if ($data['role'] === 'farmer') {
            $stmt = $conn->prepare("INSERT INTO farmer (name, address, contact, year_of_experience, gender, password) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", 
                $data['name'],
                $data['address'],
                $data['contact'],
                $data['experience'],
                $data['gender'],
                $data['password']
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO vendor (license_id, name, address, reg_date, vendor_type, contact, password) 
                                  VALUES (?, ?, ?, CURDATE(), ?, ?, ?)");
            $stmt->bind_param("ssssss",
                $data['license_id'],
                $data['name'],
                $data['address'],
                $data['vendor_type'],
                $data['contact'],
                $data['password']
            );
        }
        
        if ($stmt->execute()) {
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Registration successful']);
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

// Handle logout
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ../login.php');
    exit();
}

$conn->close();
?>
