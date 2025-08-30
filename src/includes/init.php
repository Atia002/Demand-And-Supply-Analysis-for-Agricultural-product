<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('Asia/Dhaka');

// Include database connection
require_once 'E:/xampp/htdocs/Demand-And-Supply-Analysis-for-Agricultural-product/config/database.php';

// Create database connection
$database = new Database();
$pdo = $database->getConnection();
?>
