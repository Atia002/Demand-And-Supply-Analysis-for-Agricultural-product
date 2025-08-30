<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'supply_demand');

// Establish database connection
$conn = null;
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8
    $conn->set_charset("utf8");
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['error_message'] = "Database connection failed. Please try again later.";
    header('Location: error.php');
    exit();
}
