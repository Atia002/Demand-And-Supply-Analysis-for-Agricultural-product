<?php
// Database credentials
$servername = "127.0.0.1";  // Using IP instead of localhost
$username = "root";
$password = "";
$database = "supply_demand";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set the correct charset
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $conn->error);
    }

    // Set timezone
    $conn->query("SET time_zone = '+06:00'");

} catch (Exception $e) {
    error_log($e->getMessage());
    die("Sorry, there was a problem connecting to the database.");
}
?>
