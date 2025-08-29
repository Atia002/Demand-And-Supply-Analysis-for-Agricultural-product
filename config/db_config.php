<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "agri_demand_supply";

try {
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
