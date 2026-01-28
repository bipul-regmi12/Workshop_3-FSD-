<?php
// $host = 'localhost';
// $db = 'school_db';
// $user = 'root';
// $pass = 'RootPassword123!';


$host = 'localhost';
$db = 'np03cs4a240282';
$user = 'np03cs4a240282';
$pass = '04a09vyPAh';

try {
    $serverPdo = new PDO(
        "mysql:host=$host;charset=utf8",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
    $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8 COLLATE utf8_general_ci");
    $serverPdo = null; // Close the connection to switch database context

    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    $pdo->exec("CREATE TABLE IF NOT EXISTS employees (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        title VARCHAR(100),
        skills TEXT
    )");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}