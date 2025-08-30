<?php
class DatabaseConnection {
    private static $instance = null;
    private $conn;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'supply_demand';

    private function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }

            // Set charset to utf8mb4
            if (!$this->conn->set_charset("utf8mb4")) {
                throw new Exception("Error setting charset: " . $this->conn->error);
            }

            // Set timezone
            $this->conn->query("SET time_zone = '+06:00'");

        } catch (Exception $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql) {
        try {
            $result = $this->conn->query($sql);
            if ($result === false) {
                throw new Exception("Query failed: " . $this->conn->error);
            }
            return $result;
        } catch (Exception $e) {
            die("Query error: " . $e->getMessage());
        }
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function escapeString($string) {
        return $this->conn->real_escape_string($string);
    }
}
?>
