<?php
require_once 'config/db_connect.php';

try {
    // Check if delivery table exists and get its structure
    $stmt = $conn->query("DESCRIBE delivery");
    echo "<h3>Delivery Table Structure:</h3>";
    echo "<pre>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
    echo "</pre>";
    
    // Get sample data
    $stmt = $conn->query("SELECT * FROM delivery LIMIT 5");
    echo "<h3>Sample Delivery Data:</h3>";
    echo "<pre>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
    echo "</pre>";
    
} catch(PDOException $e) {
    if($e->getCode() == '42S02') {
        echo "The delivery table does not exist.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
