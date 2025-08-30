<?php
require_once 'includes/db_connection.php';

try {
    // Get database connection instance
    $db = DatabaseConnection::getInstance();
    $conn = $db->getConnection();
    
    if ($conn->ping()) {
        echo "Database connection successful!\n";
        echo "Server info: " . $conn->server_info . "\n";
        echo "Host info: " . $conn->host_info . "\n";
        
        // Test a simple query
        $result = $db->query("SELECT DATABASE()");
        $row = $result->fetch_row();
        echo "Current database: " . $row[0] . "\n";
    } else {
        echo "Database connection failed!";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
