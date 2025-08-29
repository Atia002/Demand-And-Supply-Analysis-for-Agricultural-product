<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection test
try {
    $conn = new PDO("mysql:host=localhost;dbname=supply_demand", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2>✅ Database Connection Test</h2>";
    echo "Successfully connected to supply_demand database<br><br>";

    // Test delivery table
    $stmt = $conn->query("SHOW COLUMNS FROM delivery");
    echo "<h3>Delivery Table Structure:</h3>";
    echo "<ul>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li><strong>" . $row['Field'] . "</strong> - " . $row['Type'] . "</li>";
    }
    echo "</ul>";

    // Test other essential tables
    $tables = ['storage', 'vendor', 'consumer'];
    echo "<h3>Related Tables:</h3>";
    foreach($tables as $table) {
        $result = $conn->query("SELECT COUNT(*) as count FROM $table");
        $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p>✅ Table <strong>$table</strong> exists with $count records</p>";
    }

} catch(PDOException $e) {
    die("<h2>❌ Connection failed:</h2>" . $e->getMessage());
}
?>
