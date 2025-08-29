<?php
class DatabaseHelper {
    private $db;
    
    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }
    
    public function getFarmerDetails($farmerId) {
        $farmerId = $this->db->escapeString($farmerId);
        return $this->db->query("SELECT * FROM farmer WHERE farmer_id = '$farmerId'");
    }
    
    public function getProductDetails($productId) {
        $productId = $this->db->escapeString($productId);
        return $this->db->query("SELECT * FROM product WHERE product_id = '$productId'");
    }
    
    public function getStorageStatus($storageId) {
        $storageId = $this->db->escapeString($storageId);
        return $this->db->query("SELECT * FROM storage WHERE storage_id = '$storageId'");
    }
    
    public function getVendorDetails($licenseId) {
        $licenseId = $this->db->escapeString($licenseId);
        return $this->db->query("SELECT * FROM vendor WHERE license_id = '$licenseId'");
    }
    
    public function getProductionData($batchNo) {
        $batchNo = $this->db->escapeString($batchNo);
        return $this->db->query("SELECT * FROM production WHERE batch_no = '$batchNo'");
    }
    
    public function getPriceHistory($productId) {
        $productId = $this->db->escapeString($productId);
        return $this->db->query("
            SELECT * FROM price_record 
            WHERE product_id = '$productId' 
            ORDER BY date DESC
        ");
    }
    
    public function addNewFarmer($name, $address, $contact, $experience, $gender) {
        $name = $this->db->escapeString($name);
        $address = $this->db->escapeString($address);
        $contact = $this->db->escapeString($contact);
        $experience = (int)$experience;
        $gender = $this->db->escapeString($gender);
        
        return $this->db->query("
            INSERT INTO farmer (name, address, contact, year_of_experience, gender)
            VALUES ('$name', '$address', '$contact', $experience, '$gender')
        ");
    }
    
    public function updateProduct($productId, $data) {
        $updates = [];
        foreach ($data as $key => $value) {
            $value = $this->db->escapeString($value);
            $updates[] = "$key = '$value'";
        }
        
        $updateStr = implode(", ", $updates);
        $productId = $this->db->escapeString($productId);
        
        return $this->db->query("
            UPDATE product 
            SET $updateStr 
            WHERE product_id = '$productId'
        ");
    }
    
    public function getDeliveryStatus($deliveryId) {
        $deliveryId = $this->db->escapeString($deliveryId);
        return $this->db->query("SELECT * FROM delivery WHERE delivery_id = '$deliveryId'");
    }
}
?>
