<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
header('Content-Type: application/json');

if (!isLoggedIn() || !isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$name = sanitize($_POST['author_name'] ?? '');
$bio = sanitize($_POST['biography'] ?? '');

if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Name is required']);
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO authors (author_name, biography) VALUES (?, ?)");
    $stmt->execute([$name, $bio]);
    echo json_encode(['success' => true, 'message' => 'Author added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to save author']);
}
?>
