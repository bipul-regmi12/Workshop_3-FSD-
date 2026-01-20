<?php



// $host = 'localhost';
// $dbname = 'np03cs4a240282';
// $username = 'np03cs4a240282';
// $password = '04a09vyPAh!';
// $charset = 'utf8mb4';


$host = 'localhost';
$dbname = 'warehouse_db';
$username = 'root';
$password = 'RootPassword123!';
$charset = 'utf8mb4';


try {

    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $conn->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET $charset COLLATE utf8mb4_general_ci");


    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $conn->exec("CREATE TABLE IF NOT EXISTS product (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(255) NOT NULL,
        supplier_name VARCHAR(255) NOT NULL,
        item_description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>