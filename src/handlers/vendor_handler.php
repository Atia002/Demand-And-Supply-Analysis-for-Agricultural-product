<?php
// Database connection
require_once 'db_connection.php';

class VendorHandler {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    // Create new vendor (handles both wholesaler and retailer)
    public function createVendor($data) {
        try {
            // Start transaction to ensure data consistency
            $this->conn->beginTransaction();

            // First insert into VENDOR table (supertype)
            $vendorQuery = "INSERT INTO VENDOR (LicenseID, Name, address, RegDate, VendorType) 
                           VALUES (:licenseID, :name, :address, :regDate, :vendorType)";
            
            $stmt = $this->conn->prepare($vendorQuery);
            $stmt->execute([
                ':licenseID' => $data['licenseID'],
                ':name' => $data['name'],
                ':address' => $data['address'],
                ':regDate' => $data['regDate'],
                ':vendorType' => $data['vendorType']
            ]);

            // Then insert into specific subtype table based on vendor type
            if ($data['vendorType'] === 'wholesaler') {
                $subQuery = "INSERT INTO WHOLESALER (LicenseID, MinOrderQuantity) 
                            VALUES (:licenseID, :minOrderQuantity)";
                $stmt = $this->conn->prepare($subQuery);
                $stmt->execute([
                    ':licenseID' => $data['licenseID'],
                    ':minOrderQuantity' => $data['minOrderQuantity']
                ]);
            } else if ($data['vendorType'] === 'retailer') {
                $subQuery = "INSERT INTO RETAILER (LicenseID, StoreType) 
                            VALUES (:licenseID, :storeType)";
                $stmt = $this->conn->prepare($subQuery);
                $stmt->execute([
                    ':licenseID' => $data['licenseID'],
                    ':storeType' => $data['storeType']
                ]);
            }

            // Commit the transaction
            $this->conn->commit();
            return ['success' => true, 'message' => 'Vendor created successfully'];

        } catch (Exception $e) {
            // Rollback on error
            $this->conn->rollBack();
            return ['success' => false, 'message' => 'Error creating vendor: ' . $e->getMessage()];
        }
    }

    // Get vendor details (including subtype-specific information)
    public function getVendorDetails($licenseID) {
        try {
            // First get the base vendor information
            $vendorQuery = "SELECT * FROM VENDOR WHERE LicenseID = :licenseID";
            $stmt = $this->conn->prepare($vendorQuery);
            $stmt->execute([':licenseID' => $licenseID]);
            $vendor = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$vendor) {
                return ['success' => false, 'message' => 'Vendor not found'];
            }

            // Get subtype-specific information
            if ($vendor['VendorType'] === 'wholesaler') {
                $subQuery = "SELECT MinOrderQuantity FROM WHOLESALER WHERE LicenseID = :licenseID";
                $stmt = $this->conn->prepare($subQuery);
                $stmt->execute([':licenseID' => $licenseID]);
                $subTypeInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                $vendor['MinOrderQuantity'] = $subTypeInfo['MinOrderQuantity'];
            } else if ($vendor['VendorType'] === 'retailer') {
                $subQuery = "SELECT StoreType FROM RETAILER WHERE LicenseID = :licenseID";
                $stmt = $this->conn->prepare($subQuery);
                $stmt->execute([':licenseID' => $licenseID]);
                $subTypeInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                $vendor['StoreType'] = $subTypeInfo['StoreType'];
            }

            return ['success' => true, 'data' => $vendor];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error retrieving vendor: ' . $e->getMessage()];
        }
    }
}

// Handle incoming requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $handler = new VendorHandler($conn);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'create':
                echo json_encode($handler->createVendor($data));
                break;
            case 'get':
                echo json_encode($handler->getVendorDetails($data['licenseID']));
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    }
}
?>
