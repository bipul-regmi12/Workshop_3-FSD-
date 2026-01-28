<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isLoggedIn() || !isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = sanitize($_POST['isbn'] ?? '');
    $title = sanitize($_POST['title'] ?? '');
    $author_id = $_POST['author_id'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $publish_year = $_POST['publish_year'] ?? null;

    if (!$isbn || !$title || !$author_id || !$category_id) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO books (isbn, title, author_id, category_id, publish_year) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$isbn, $title, $author_id, $category_id, $publish_year]);
        
        echo json_encode(['success' => true, 'message' => 'Book added successfully']);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['success' => false, 'message' => 'ISBN already exists']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
}
?>
