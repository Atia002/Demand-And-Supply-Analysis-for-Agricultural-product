<?php
require_once '../config/db_connect.php';

header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            // Fetch deliveries
            $stmt = $conn->prepare("
                SELECT d.*, 
                       s1.address as from_address,
                       s2.address as to_address,
                       v.name as vendor_name,
                       c.name as consumer_name
                FROM delivery d
                LEFT JOIN storage s1 ON d.from_storage_id = s1.storage_id
                LEFT JOIN storage s2 ON d.to_storage_id = s2.storage_id
                LEFT JOIN vendor v ON d.vendor_id = v.license_id
                LEFT JOIN consumer c ON d.consumer_id = c.consumer_id
                ORDER BY d.date DESC
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $result]);
            break;

        case 'POST':
            // Add new delivery
            $stmt = $conn->prepare("
                INSERT INTO delivery (
                    from_storage_id, 
                    to_storage_id, 
                    date, 
                    transport_mode, 
                    status,
                    vendor_id,
                    consumer_id
                ) VALUES (
                    :from_storage_id,
                    :to_storage_id,
                    :date,
                    :transport_mode,
                    'Pending',
                    :vendor_id,
                    :consumer_id
                )
            ");

            $stmt->execute([
                ':from_storage_id' => $_POST['from_storage_id'],
                ':to_storage_id' => $_POST['to_storage_id'],
                ':date' => $_POST['date'],
                ':transport_mode' => $_POST['transport_mode'],
                ':vendor_id' => $_POST['vendor_id'] ?: null,
                ':consumer_id' => $_POST['consumer_id'] ?: null
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Delivery added successfully',
                'delivery_id' => $conn->lastInsertId()
            ]);
            break;

        case 'DELETE':
            // Delete delivery
            $data = json_decode(file_get_contents('php://input'), true);
            $delivery_id = $data['delivery_id'];

            $stmt = $conn->prepare("DELETE FROM delivery WHERE delivery_id = :delivery_id");
            $stmt->execute([':delivery_id' => $delivery_id]);

            echo json_encode([
                'success' => true,
                'message' => 'Delivery deleted successfully'
            ]);
            break;

        case 'PUT':
            // Update delivery
            $data = json_decode(file_get_contents('php://input'), true);
            
            $stmt = $conn->prepare("
                UPDATE delivery 
                SET from_storage_id = :from_storage_id,
                    to_storage_id = :to_storage_id,
                    date = :date,
                    transport_mode = :transport_mode,
                    status = :status,
                    vendor_id = :vendor_id,
                    consumer_id = :consumer_id
                WHERE delivery_id = :delivery_id
            ");

            $stmt->execute([
                ':delivery_id' => $data['delivery_id'],
                ':from_storage_id' => $data['from_storage_id'],
                ':to_storage_id' => $data['to_storage_id'],
                ':date' => $data['date'],
                ':transport_mode' => $data['transport_mode'],
                ':status' => $data['status'],
                ':vendor_id' => $data['vendor_id'] ?: null,
                ':consumer_id' => $data['consumer_id'] ?: null
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Delivery updated successfully'
            ]);
            break;

        default:
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
            break;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
