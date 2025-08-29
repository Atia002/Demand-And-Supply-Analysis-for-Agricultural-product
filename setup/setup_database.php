<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    // Create connection without database
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS agri_demand_supply";
    if ($conn->query($sql) === TRUE) {
        echo "✅ Database created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // Select the database
    $conn->select_db("agri_demand_supply");

    // Import schema
    $schema = file_get_contents("../database/db_schema.sql");
    
    if ($schema === false) {
        throw new Exception("Could not read schema file");
    }

    // Split schema into individual queries
    $queries = array_filter(array_map('trim', explode(';', $schema)));
    
    foreach ($queries as $query) {
        if (empty($query)) continue;
        
        if ($conn->query($query) === FALSE) {
            throw new Exception("Error executing query: " . $conn->error . "\nQuery was: " . $query);
        }
    }

    echo "✅ Schema imported successfully<br>";
    echo "✅ Database setup complete!";

} catch (Exception $e) {
    die("❌ Setup error: " . $e->getMessage());
}
?>
