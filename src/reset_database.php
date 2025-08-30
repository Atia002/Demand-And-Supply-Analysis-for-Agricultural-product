<?php
require_once 'db.php';

try {
    // Array of table names in order of dependencies (child tables first)
    $tables = [
        'nutrition_value',
        'price_record',
        'production',
        'delivery',
        'retailer',
        'wholesaler',
        'vendor',
        'storage',
        'weather',
        'district',
        'farm',
        'product',
        'farmer',
        'consumer',
        'gdp'
    ];

    // Drop existing tables
    foreach ($tables as $table) {
        $sql = "DROP TABLE IF EXISTS $table";
        if (!$conn->query($sql)) {
            throw new Exception("Error dropping table $table: " . $conn->error);
        }
    }

    echo "All existing tables dropped successfully.<br>";

    // Read and execute the schema file
    $schema = file_get_contents('database/db_schema.sql');
    if ($schema === false) {
        throw new Exception("Could not read schema file");
    }

    // Split the schema into individual queries
    $queries = array_filter(array_map('trim', explode(';', $schema)));
    
    foreach ($queries as $query) {
        if (!empty($query)) {
            if (!$conn->query($query)) {
                throw new Exception("Error executing query: " . $conn->error . "\nQuery: " . $query);
            }
        }
    }

    echo "Database schema recreated successfully!";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    error_log($e->getMessage());
}
?>
