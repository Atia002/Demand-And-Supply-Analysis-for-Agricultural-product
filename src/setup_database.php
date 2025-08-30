<?php
require_once 'includes/db_connection.php';

try {
    // Get database connection instance
    $db = DatabaseConnection::getInstance();
    $conn = $db->getConnection();
    
    // Read and execute the SQL schema
    $sql = file_get_contents('database/db_schema.sql');
    
    // Split SQL file into individual queries
    $queries = array_filter(array_map('trim', explode(';', $sql)));
    
    // Execute each query
    foreach ($queries as $query) {
        if (!empty($query)) {
            if ($conn->query($query) === TRUE) {
                echo "Successfully executed: " . substr($query, 0, 50) . "...\n";
            } else {
                throw new Exception("Error executing query: " . $conn->error);
            }
        }
    }
    
    echo "\nDatabase setup completed successfully!";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
