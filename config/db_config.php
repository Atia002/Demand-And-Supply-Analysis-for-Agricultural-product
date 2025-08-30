<?php

$servername = "localhost";

$username = "root";

$password = "";

$dbname = "supply_demand";

$conn = new mysqli($servername, $username, $password, $dbname, 80);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} else {
    echo "<script>console.log('Database Connected successfully');</script>";
}