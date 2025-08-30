<?php
require_once('../config/db_config.php');

class ProductManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addProduct($name, $type, $variety, $sowingTime, $transplantingTime, $harvestTime, $perAcreSeedRequirement) {
        $sql = "INSERT INTO PRODUCT (name, type, variety, sowing_time, transplanting_time, harvest_time, per_acre_seed_requirement) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssd", $name, $type, $variety, $sowingTime, $transplantingTime, $harvestTime, $perAcreSeedRequirement);
        
        return $stmt->execute();
    }

    public function updateProduct($productId, $name, $type, $variety, $sowingTime, $transplantingTime, $harvestTime, $perAcreSeedRequirement) {
        $sql = "UPDATE PRODUCT 
                SET name = ?, type = ?, variety = ?, sowing_time = ?, transplanting_time = ?, 
                    harvest_time = ?, per_acre_seed_requirement = ? 
                WHERE product_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssdi", $name, $type, $variety, $sowingTime, $transplantingTime, 
                         $harvestTime, $perAcreSeedRequirement, $productId);
        
        return $stmt->execute();
    }

    public function deleteProduct($productId) {
        $sql = "DELETE FROM PRODUCT WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        
        return $stmt->execute();
    }

    public function getProduct($productId) {
        $sql = "SELECT * FROM PRODUCT WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM PRODUCT";
        $result = $this->conn->query($sql);
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }

    public function getProductPriceHistory($productId) {
        $sql = "SELECT * FROM PRICE_RECORD WHERE product_id = ? ORDER BY date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        $prices = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $prices[] = $row;
        }
        
        return $prices;
    }

    public function addPriceRecord($productId, $date, $priceValue, $priceType) {
        $sql = "INSERT INTO PRICE_RECORD (product_id, date, price_value, price_type) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isds", $productId, $date, $priceValue, $priceType);
        
        return $stmt->execute();
    }

    public function getProductionHistory($productId) {
        $sql = "SELECT * FROM PRODUCTION WHERE product_id = ? ORDER BY year DESC, season DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        $production = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $production[] = $row;
        }
        
        return $production;
    }
}

// API Endpoints for Product Management
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productManager = new ProductManager($conn);
    $data = json_decode(file_get_contents('php://input'), true);
    $response = ['success' => false, 'message' => ''];

    try {
        switch($_GET['action']) {
            case 'add':
                if ($productManager->addProduct(
                    $data['name'],
                    $data['type'],
                    $data['variety'],
                    $data['sowingTime'],
                    $data['transplantingTime'],
                    $data['harvestTime'],
                    $data['perAcreSeedRequirement']
                )) {
                    $response = ['success' => true, 'message' => 'Product added successfully'];
                }
                break;

            case 'update':
                if ($productManager->updateProduct(
                    $data['productId'],
                    $data['name'],
                    $data['type'],
                    $data['variety'],
                    $data['sowingTime'],
                    $data['transplantingTime'],
                    $data['harvestTime'],
                    $data['perAcreSeedRequirement']
                )) {
                    $response = ['success' => true, 'message' => 'Product updated successfully'];
                }
                break;

            case 'delete':
                if ($productManager->deleteProduct($data['productId'])) {
                    $response = ['success' => true, 'message' => 'Product deleted successfully'];
                }
                break;

            case 'addPrice':
                if ($productManager->addPriceRecord(
                    $data['productId'],
                    $data['date'],
                    $data['priceValue'],
                    $data['priceType']
                )) {
                    $response = ['success' => true, 'message' => 'Price record added successfully'];
                }
                break;

            default:
                $response['message'] = 'Invalid action';
        }
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productManager = new ProductManager($conn);
    $response = ['success' => false, 'data' => null, 'message' => ''];

    try {
        switch($_GET['action']) {
            case 'get':
                if (isset($_GET['productId'])) {
                    $response['data'] = $productManager->getProduct($_GET['productId']);
                    $response['success'] = true;
                }
                break;

            case 'getAll':
                $response['data'] = $productManager->getAllProducts();
                $response['success'] = true;
                break;

            case 'getPriceHistory':
                if (isset($_GET['productId'])) {
                    $response['data'] = $productManager->getProductPriceHistory($_GET['productId']);
                    $response['success'] = true;
                }
                break;

            case 'getProductionHistory':
                if (isset($_GET['productId'])) {
                    $response['data'] = $productManager->getProductionHistory($_GET['productId']);
                    $response['success'] = true;
                }
                break;

            default:
                $response['message'] = 'Invalid action';
        }
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
