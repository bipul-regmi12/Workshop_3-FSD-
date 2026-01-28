<?php
$db_host = 'localhost';
$db_name = 'luminalib_db';
$db_user = 'root';
$db_pass = 'RootPassword123!';

try {
    // 1. Initial connection to MySQL (without selecting a DB)
    $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // 2. Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // 3. Select the database
    $pdo->exec("USE `$db_name`");

    // 4. Create Tables if they don't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        role_name VARCHAR(50) NOT NULL UNIQUE
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role_id INT,
        FOREIGN KEY (role_id) REFERENCES roles(id)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS authors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        author_name VARCHAR(100) NOT NULL,
        biography TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(50) NOT NULL UNIQUE
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        isbn VARCHAR(20) NOT NULL UNIQUE,
        title VARCHAR(255) NOT NULL,
        author_id INT,
        category_id INT,
        publish_year INT,
        status ENUM('Available', 'Pending', 'Issued') DEFAULT 'Available',
        FOREIGN KEY (author_id) REFERENCES authors(id),
        FOREIGN KEY (category_id) REFERENCES categories(id)
    )");

    // 5. Seed initial data (Check if roles exist first)
    $stmt = $pdo->query("SELECT COUNT(*) FROM roles");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO roles (role_name) VALUES ('Admin'), ('Patron')");
        
        // Default Admin: admin / password123
        $adminHash = '$2y$10$b047vYt29he4TsJALaaS/OtwEw1EEEhfqeeIkqvnZI8E0u/41iJ9i';
        $pdo->exec("INSERT INTO users (username, password_hash, role_id) VALUES 
                   ('admin', '$adminHash', 1),
                   ('patron', '$adminHash', 2)");

        $pdo->exec("INSERT INTO categories (category_name) VALUES ('Science Fiction'), ('Technology'), ('History'), ('Philosophy')");
        $pdo->exec("INSERT INTO authors (author_name, biography) VALUES ('Isaac Asimov', 'Author of Foundation series'), ('Walter Isaacson', 'Biographer of many greats')");
        $pdo->exec("INSERT INTO books (isbn, title, author_id, category_id, publish_year, status) VALUES 
                   ('978-0553293357', 'Foundation', 1, 1, 1951, 'Available'),
                   ('978-1501163401', 'Leonardo da Vinci', 2, 3, 2017, 'Available')");
    }

    // Set final PDO attributes for the rest of the app
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    die("Database Initialization Failed: " . $e->getMessage());
}
?>
