<?php
header('Content-Type: application/json');
require_once('../config/db_connect.php');

// Get market trends
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'getPrices':
            // Get price trends for a product
            $stmt = $conn->prepare("
                SELECT pr.date, pr.price_value, pr.price_type, p.name as product_name
                FROM price_record pr
                JOIN product p ON pr.product_id = p.product_id
                WHERE pr.product_id = ?
                ORDER BY pr.date DESC
                LIMIT 30
            ");
            $stmt->bind_param("i", $_GET['product_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $prices = array();
            while($row = $result->fetch_assoc()) {
                $prices[] = $row;
            }
            echo json_encode(['success' => true, 'data' => $prices]);
            break;
            
        case 'getSupplyDemand':
            // Calculate supply and demand metrics
            $stmt = $conn->prepare("
                SELECT 
                    p.name as product_name,
                    SUM(prod.quantity) as total_supply,
                    COUNT(DISTINCT prod.farmer_id) as num_producers,
                    AVG(pr.price_value) as avg_price
                FROM product p
                LEFT JOIN production prod ON p.product_id = prod.product_id
                LEFT JOIN price_record pr ON p.product_id = pr.product_id
                WHERE p.product_id = ?
                GROUP BY p.product_id
            ");
            $stmt->bind_param("i", $_GET['product_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
            break;
            
        case 'getMarketSummary':
            // Get overall market summary
            $result = $conn->query("
                SELECT 
                    COUNT(DISTINCT p.product_id) as total_products,
                    COUNT(DISTINCT f.farmer_id) as total_farmers,
                    COUNT(DISTINCT v.license_id) as total_vendors,
                    (SELECT COUNT(*) FROM delivery WHERE status = 'In Transit') as active_deliveries
                FROM product p
                CROSS JOIN farmer f
                CROSS JOIN vendor v
                LIMIT 1
            ");
            
            echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
            break;
            
        case 'getWeatherImpact':
            // Get weather impact on prices
            $stmt = $conn->prepare("
                SELECT 
                    w.date,
                    w.temperature_c,
                    w.rainfall_mm,
                    pr.price_value,
                    p.name as product_name
                FROM weather w
                JOIN district d ON w.district_id = d.district_id
                JOIN price_record pr ON DATE(w.date) = DATE(pr.date)
                JOIN product p ON pr.product_id = p.product_id
                WHERE p.product_id = ? AND d.district_id = ?
                ORDER BY w.date DESC
                LIMIT 30
            ");
            $stmt->bind_param("ii", $_GET['product_id'], $_GET['district_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(['success' => true, 'data' => $data]);
            break;
    }
}

// Add price record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addPrice') {
    try {
        $stmt = $conn->prepare("
            INSERT INTO price_record (product_id, date, price_value, price_type)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("isds", 
            $_POST['product_id'],
            $_POST['date'],
            $_POST['price_value'],
            $_POST['price_type']
        );
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Price record added successfully']);
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

$conn->close();
?>
