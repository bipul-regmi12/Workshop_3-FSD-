-- Create database
CREATE DATABASE IF NOT EXISTS inventory_db;

-- Use the database
USE inventory_db;

-- Create product table
CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    supplier_name VARCHAR(255) NOT NULL,
    item_description TEXT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
