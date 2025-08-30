<?php
header('Content-Type: application/json');
require_once './config/db_config.php';

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Get the request path
$path = isset($_GET['path']) ? $_GET['path'] : '';
$method = $_SERVER['REQUEST_METHOD'];

// Route the request to the appropriate handler
try {
    switch ($path) {
        case 'farmer':
            require_once './handlers/farmer_handler.php';
            break;
            
        case 'product':
            require_once './handlers/product_handler.php';
            break;
            
        case 'vendor':
            require_once './handlers/vendor_handler.php';
            break;
            
        case 'market':
            require_once './handlers/market_handler.php';
            break;
            
        case 'storage':
            require_once './handlers/storage_handler.php';
            break;
            
        case 'delivery':
            require_once './handlers/delivery_handler.php';
            break;
            
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
