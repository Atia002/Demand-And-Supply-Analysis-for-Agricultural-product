<?php
class Database {
    private $host = "127.0.0.1";
    private $db_name = "supply_demand";
    private $username = "root";
    private $password = "";
    private $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . 
                   ";dbname=" . $this->db_name . 
                   ";charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
            // Set timezone
            $this->conn->exec("SET time_zone = '+06:00'");
            
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            die("Sorry, there was a problem connecting to the database.");
        }

        return $this->conn;
    }

    // Close the database connection
    public function closeConnection() {
        $this->conn = null;
    }
}
?>
