
<?php
$host = 'localhost';
$db = 'np03cs4s240161';
$user = 'np03cs4s240161';
$pass = 'YXTRdLGSsM';


try {
    $conn = new PDO("mysql:host=$host", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE DATABASE IF NOT EXISTS $db");
    $conn->exec("USE $db");

    $conn->exec("CREATE TABLE IF NOT EXISTS Gymmembers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        member_name VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) NOT NULL,
        plan_type VARCHAR(50) NOT NULL,
        duration_months INT NOT NULL,
        joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

