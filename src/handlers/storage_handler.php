<?php
require_once '../config/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            $stmt = $conn->prepare("SELECT * FROM storage ORDER BY address");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $result]);
            break;

        case 'POST':
            $stmt = $conn->prepare("
                INSERT INTO storage (address, capacity, type)
                VALUES (:address, :capacity, :type)
            ");

            $stmt->execute([
                ':address' => $_POST['address'],
                ':capacity' => $_POST['capacity'],
                ':type' => $_POST['type']
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Storage location added successfully',
                'storage_id' => $conn->lastInsertId()
            ]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            $stmt = $conn->prepare("
                UPDATE storage 
                SET address = :address,
                    capacity = :capacity,
                    type = :type
                WHERE storage_id = :storage_id
            ");

            $stmt->execute([
                ':storage_id' => $data['storage_id'],
                ':address' => $data['address'],
                ':capacity' => $data['capacity'],
                ':type' => $data['type']
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Storage location updated successfully'
            ]);
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            
            $stmt = $conn->prepare("DELETE FROM storage WHERE storage_id = :storage_id");
            $stmt->execute([':storage_id' => $data['storage_id']]);

            echo json_encode([
                'success' => true,
                'message' => 'Storage location deleted successfully'
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
