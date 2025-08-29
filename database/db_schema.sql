-- Create the database
CREATE DATABASE IF NOT EXISTS agri_demand_supply;
USE agri_demand_supply;

-- Create FARMER table
CREATE TABLE FARMER (
    farmer_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    contact VARCHAR(15),
    year_of_experience INT,
    gender ENUM('Male', 'Female', 'Other')
);

-- Create FARM table
CREATE TABLE FARM (
    farm_id INT PRIMARY KEY AUTO_INCREMENT,
    address TEXT NOT NULL,
    farmer_id INT,
    FOREIGN KEY (farmer_id) REFERENCES FARMER(farmer_id)
);

-- Create PRICE_RECORD table
CREATE TABLE PRICE_RECORD (
    record_id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    price_value DECIMAL(10,2) NOT NULL,
    price_type ENUM('Wholesale', 'Retail', 'Farm Gate') NOT NULL,
    product_id INT
);

-- Create PRODUCT table
CREATE TABLE PRODUCT (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50),
    variety VARCHAR(100),
    sowing_time DATE,
    transplanting_time DATE,
    harvest_time DATE,
    per_acre_seed_requirement DECIMAL(10,2)
);

-- Add foreign key to PRICE_RECORD after PRODUCT table is created
ALTER TABLE PRICE_RECORD
ADD FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id);

-- Create PRODUCTION table
CREATE TABLE PRODUCTION (
    batch_no VARCHAR(50) PRIMARY KEY,
    year INT NOT NULL,
    season ENUM('Rabi', 'Kharif', 'Zaid') NOT NULL,
    acre_age DECIMAL(10,2) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    product_id INT,
    farmer_id INT,
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id),
    FOREIGN KEY (farmer_id) REFERENCES FARMER(farmer_id)
);

-- Create DISTRICT table
CREATE TABLE DISTRICT (
    district_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    division VARCHAR(100) NOT NULL
);

-- Create WEATHER table
CREATE TABLE WEATHER (
    weather_id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    temperature_c DECIMAL(5,2),
    rainfall_mm DECIMAL(10,2),
    district_id INT,
    FOREIGN KEY (district_id) REFERENCES DISTRICT(district_id)
);

-- Create STORAGE table
CREATE TABLE STORAGE (
    storage_id INT PRIMARY KEY AUTO_INCREMENT,
    cold_storage_capacity DECIMAL(10,2),
    address TEXT,
    product_type VARCHAR(50),
    stock_level DECIMAL(10,2)
);

-- Create VENDOR table
CREATE TABLE VENDOR (
    license_id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    reg_date DATE NOT NULL,
    vendor_type ENUM('Wholesaler', 'Retailer') NOT NULL
);

-- Create WHOLESALER table (inherits from VENDOR)
CREATE TABLE WHOLESALER (
    license_id VARCHAR(50) PRIMARY KEY,
    min_order_quantity DECIMAL(10,2),
    FOREIGN KEY (license_id) REFERENCES VENDOR(license_id)
);

-- Create RETAILER table (inherits from VENDOR)
CREATE TABLE RETAILER (
    license_id VARCHAR(50) PRIMARY KEY,
    store_type VARCHAR(50),
    FOREIGN KEY (license_id) REFERENCES VENDOR(license_id)
);

-- Create CONSUMER table
CREATE TABLE CONSUMER (
    consumer_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    contact VARCHAR(15),
    email VARCHAR(100),
    region VARCHAR(100),
    address TEXT,
    feedback TEXT
);

-- Create DELIVERY table
CREATE TABLE DELIVERY (
    delivery_id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    transport_mode VARCHAR(50),
    status ENUM('Pending', 'In Transit', 'Delivered', 'Cancelled') NOT NULL,
    type VARCHAR(50),
    from_storage_id INT,
    to_storage_id INT,
    vendor_id VARCHAR(50),
    consumer_id INT,
    FOREIGN KEY (from_storage_id) REFERENCES STORAGE(storage_id),
    FOREIGN KEY (to_storage_id) REFERENCES STORAGE(storage_id),
    FOREIGN KEY (vendor_id) REFERENCES VENDOR(license_id),
    FOREIGN KEY (consumer_id) REFERENCES CONSUMER(consumer_id)
);

-- Create GDP table
CREATE TABLE GDP (
    year INT PRIMARY KEY,
    population BIGINT,
    gdp_value DECIMAL(15,2),
    source VARCHAR(100)
);

-- Create NUTRITION_VALUE table
CREATE TABLE NUTRITION_VALUE (
    nutrition_id INT PRIMARY KEY AUTO_INCREMENT,
    quantity DECIMAL(10,2),
    gender ENUM('Male', 'Female', 'All'),
    age_group VARCHAR(50),
    source VARCHAR(100),
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id)
);
