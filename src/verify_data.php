<?php
require_once 'includes/db_connection.php';

try {
    // Get database connection instance
    $db = DatabaseConnection::getInstance();
    $conn = $db->getConnection();
    
    echo "<h2>Database Connection Test</h2>";
    
    if ($conn->ping()) {
        echo "<p style='color: green;'>✓ Database connection successful!</p>";
        echo "<p>Server Info: " . $conn->server_info . "</p>";
        echo "<p>Host Info: " . $conn->host_info . "</p>";
        
        // Test database name
        $result = $db->query("SELECT DATABASE()");
        $row = $result->fetch_row();
        echo "<p>Current database: " . $row[0] . "</p>";
        
        // Check tables
        $tables = array(
            'consumer', 'delivery', 'district', 'farm', 'farmer',
            'gdp', 'nutrition_value', 'price_record', 'product',
            'production', 'retailer', 'storage', 'vendor',
            'weather', 'wholesaler'
        );
        
        echo "<h3>Table Status:</h3>";
        echo "<ul>";
        
        foreach ($tables as $table) {
            $result = $db->query("SELECT COUNT(*) as count FROM $table");
            $count = $result->fetch_assoc()['count'];
            echo "<li>$table: $count records</li>";
        }
        
        echo "</ul>";
        
    } else {
        echo "<p style='color: red;'>✗ Database connection failed!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
require_once 'db.php';

if (!$conn) {
    die("Database connection failed");
}

// Tables to verify
$tables = array(
    'farmer',
    'farm',
    'product',
    'production',
    'vendor',
    'wholesaler',
    'retailer',
    'storage',
    'delivery',
    'weather',
    'district',
    'gdp',
    'nutrition_value',
    'price_record'
);

echo "<html><head><title>Database Verification</title>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .table-info { margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; }
    .success { color: green; }
    .warning { color: orange; }
    .error { color: red; }
</style></head><body>";

echo "<h1>Database Verification Report</h1>";

foreach ($tables as $table) {
    echo "<div class='table-info'>";
    echo "<h3>Table: $table</h3>";
    
    // Check if table exists
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        // Count records
        $count = $conn->query("SELECT COUNT(*) as total FROM $table");
        $count = $count->fetch_assoc();
        
        echo "<p class='success'>✓ Table exists</p>";
        echo "<p>Total records: " . $count['total'] . "</p>";
        
        // Show sample data
        $sample = $conn->query("SELECT * FROM $table LIMIT 1");
        if ($sample->num_rows > 0) {
            $row = $sample->fetch_assoc();
            echo "<p>Sample data (First record):</p>";
            echo "<pre>" . print_r($row, true) . "</pre>";
        } else {
            echo "<p class='warning'>⚠ Table is empty</p>";
        }
    } else {
        echo "<p class='error'>✗ Table does not exist</p>";
    }
    echo "</div>";
}

// Close connection
$conn->close();

echo "</body></html>";
?>
