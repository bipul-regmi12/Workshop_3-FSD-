<?php
$host = 'localhost';
$db = 'np03cs4a240282';
$user = 'np03cs4a240282';
$pass = '04a09vyPAh';

// $host = 'localhost';
// $db = 'student_portal';
// $user = 'root';
// $pass = 'RootPassword123!';

try {
    // Connect without database first
    $conn = new PDO("mysql:host=$host", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $conn->exec("CREATE DATABASE IF NOT EXISTS $db");
    $conn->exec("USE $db");

    // Create students table if not exists
    $conn->exec("CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(50) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL
    )");

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>