<?php
require_once 'src/config/db_config.php';

if ($conn->ping()) {
    echo "✓ Database connection successful!<br>";
    echo "Server info: " . $conn->server_info . "<br>";
    echo "Host info: " . $conn->host_info . "<br>";
    
    // Test if our database exists
    $result = $conn->query("SELECT DATABASE()");
    $row = $result->fetch_row();
    echo "Current database: " . $row[0] . "<br>";
    
    // List all tables
    echo "<h3>Tables in database:</h3>";
    $result = $conn->query("SHOW TABLES");
    echo "<ul>";
    while ($row = $result->fetch_row()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "✗ Database connection failed!";
}
?>
