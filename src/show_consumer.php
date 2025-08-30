<?php
require_once 'db.php';

if ($conn) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Consumer Data</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .container { padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
            table { border-collapse: collapse; width: 100%; margin-top: 10px; }
            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
            th { background-color: #f5f5f5; }
            tr:nth-child(even) { background-color: #f9f9f9; }
            tr:hover { background-color: #f5f5f5; }
            .success { color: green; }
            .error { color: red; }
        </style>
    </head>
    <body>";
    
    echo "<div class='container'>";
    echo "<h2>Consumer Table Data</h2>";
    
    // Show consumer table data
    $query = "SELECT * FROM consumer";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        echo "<table>";
        
        // Headers
        $first = true;
        while ($row = $result->fetch_assoc()) {
            if ($first) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                }
                echo "</tr>";
                $first = false;
                
                // Reset result pointer to beginning
                $result->data_seek(0);
            }
            
            // Data
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<p class='success'>Total Records: " . $result->num_rows . "</p>";
    } else {
        echo "<p class='error'>No data found in consumer table</p>";
    }
    
    echo "</div>";
    echo "</body></html>";
} else {
    echo "<p class='error'>Database connection failed!</p>";
}
?>
