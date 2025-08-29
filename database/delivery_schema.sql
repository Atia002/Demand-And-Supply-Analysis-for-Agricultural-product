-- Add delivery table
CREATE TABLE IF NOT EXISTS delivery (
    delivery_id INT AUTO_INCREMENT PRIMARY KEY,
    from_storage_id INT,
    to_storage_id INT,
    date DATE NOT NULL,
    transport_mode ENUM('Road', 'Rail', 'Air', 'Sea') NOT NULL,
    status ENUM('Pending', 'In Transit', 'Delivered', 'Cancelled') NOT NULL DEFAULT 'Pending',
    vendor_id INT,
    consumer_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (from_storage_id) REFERENCES storage(storage_id) ON DELETE SET NULL,
    FOREIGN KEY (to_storage_id) REFERENCES storage(storage_id) ON DELETE SET NULL,
    FOREIGN KEY (vendor_id) REFERENCES vendor(license_id) ON DELETE SET NULL,
    FOREIGN KEY (consumer_id) REFERENCES consumer(consumer_id) ON DELETE SET NULL
);

-- Add storage table if not exists
CREATE TABLE IF NOT EXISTS storage (
    storage_id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) NOT NULL,
    capacity DECIMAL(10,2) NOT NULL,
    type ENUM('Cold Storage', 'Dry Storage', 'Warehouse') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Add consumer table if not exists
CREATE TABLE IF NOT EXISTS consumer (
    consumer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
