<?php
require_once('../config/db_config.php');

class FarmerManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addFarmer($name, $address, $contact, $yearOfExperience, $gender) {
        $sql = "INSERT INTO FARMER (name, address, contact, year_of_experience, gender) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssis", $name, $address, $contact, $yearOfExperience, $gender);
        
        return $stmt->execute();
    }

    public function updateFarmer($farmerId, $name, $address, $contact, $yearOfExperience, $gender) {
        $sql = "UPDATE FARMER 
                SET name = ?, address = ?, contact = ?, year_of_experience = ?, gender = ? 
                WHERE farmer_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssisi", $name, $address, $contact, $yearOfExperience, $gender, $farmerId);
        
        return $stmt->execute();
    }

    public function deleteFarmer($farmerId) {
        $sql = "DELETE FROM FARMER WHERE farmer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $farmerId);
        
        return $stmt->execute();
    }

    public function getFarmer($farmerId) {
        $sql = "SELECT * FROM FARMER WHERE farmer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $farmerId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllFarmers() {
        $sql = "SELECT * FROM FARMER";
        $result = $this->conn->query($sql);
        
        $farmers = [];
        while ($row = $result->fetch_assoc()) {
            $farmers[] = $row;
        }
        
        return $farmers;
    }

    public function getFarmerFarms($farmerId) {
        $sql = "SELECT * FROM FARM WHERE farmer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $farmerId);
        $stmt->execute();
        
        $farms = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $farms[] = $row;
        }
        
        return $farms;
    }
}

// API Endpoints for Farmer Management
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farmerManager = new FarmerManager($conn);
    $data = json_decode(file_get_contents('php://input'), true);
    $response = ['success' => false, 'message' => ''];

    try {
        switch($_GET['action']) {
            case 'add':
                if ($farmerManager->addFarmer(
                    $data['name'],
                    $data['address'],
                    $data['contact'],
                    $data['yearOfExperience'],
                    $data['gender']
                )) {
                    $response = ['success' => true, 'message' => 'Farmer added successfully'];
                }
                break;

            case 'update':
                if ($farmerManager->updateFarmer(
                    $data['farmerId'],
                    $data['name'],
                    $data['address'],
                    $data['contact'],
                    $data['yearOfExperience'],
                    $data['gender']
                )) {
                    $response = ['success' => true, 'message' => 'Farmer updated successfully'];
                }
                break;

            case 'delete':
                if ($farmerManager->deleteFarmer($data['farmerId'])) {
                    $response = ['success' => true, 'message' => 'Farmer deleted successfully'];
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
    $farmerManager = new FarmerManager($conn);
    $response = ['success' => false, 'data' => null, 'message' => ''];

    try {
        switch($_GET['action']) {
            case 'get':
                if (isset($_GET['farmerId'])) {
                    $response['data'] = $farmerManager->getFarmer($_GET['farmerId']);
                    $response['success'] = true;
                }
                break;

            case 'getAll':
                $response['data'] = $farmerManager->getAllFarmers();
                $response['success'] = true;
                break;

            case 'getFarms':
                if (isset($_GET['farmerId'])) {
                    $response['data'] = $farmerManager->getFarmerFarms($_GET['farmerId']);
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
