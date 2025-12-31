<?php
$host = 'localhost';
// $db   = 'school_db';
// $user = 'root'; 
// $pass = 'RootPassword123!';
$charset = 'utf8mb4';

// $host = 'localhost'
$db = "np03cs4a240282";
$user = "np03cs4a240282";
$pass = "04a09vyPAh";




$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Connection failed: " . $e->getMessage());
}
?>
