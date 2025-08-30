<?php
// Start session for error handling
session_start();

// Include database connection
require_once 'db.php';

try {
    if (!$conn) {
        throw new Exception("Database connection not available");
    }

    // Step 1: Get existing data from your tables
    function getExistingData($connection, $tableName) {
        $data = array();
        $result = $connection->query("SELECT * FROM $tableName");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }
        return $data;
    }

    // Step 2: Function to generate INSERT query
    function generateInsertQuery($tableName, $data) {
        if (empty($data)) return null;
        
        $columns = array_keys($data[0]);
        $query = "INSERT INTO $tableName (" . implode(", ", $columns) . ") VALUES ";
        
        $values = array();
        foreach ($data as $row) {
            $rowValues = array();
            foreach ($row as $value) {
                $rowValues[] = $conn->real_escape_string($value);
            }
            $values[] = "('" . implode("', '", $rowValues) . "')";
        }
        
        $query .= implode(", ", $values);
        return $query;
    }

    // Step 3: Transfer data for each table
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

    foreach ($tables as $table) {
        try {
            // Get data from table
            $data = getExistingData($conn, $table);
            
            if (!empty($data)) {
                // Generate and execute insert query
                $query = generateInsertQuery($table, $data);
                if ($query && $conn->query($query)) {
                    echo "Successfully migrated data for table: $table<br>";
                } else {
                    echo "No data to migrate for table: $table<br>";
                }
            } else {
                echo "No existing data found in table: $table<br>";
            }
        } catch (Exception $e) {
            echo "Error migrating table $table: " . $e->getMessage() . "<br>";
        }
    }

    echo "Data migration completed successfully!";

} catch (Exception $e) {
    $_SESSION['error_message'] = "Error during data migration: " . $e->getMessage();
    header('Location: error.php');
    exit();
}

// Function to verify data after migration
function verifyData($conn, $tableName) {
    $result = $conn->query("SELECT COUNT(*) as count FROM $tableName");
    $row = $result->fetch_assoc();
    echo "Table $tableName has {$row['count']} records<br>";
}

echo "<h2>Verifying Data After Migration:</h2>";
foreach ($tables as $table) {
    verifyData($conn, $table);
}
?>
