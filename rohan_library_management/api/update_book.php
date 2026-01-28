<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'] ?? null;
    $isbn = sanitize($_POST['isbn'] ?? '');
    $title = sanitize($_POST['title'] ?? '');
    $author_id = $_POST['author_id'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $publish_year = $_POST['publish_year'] ?? null;

    if (!isAdmin()) {
        echo json_encode(['success' => false, 'message' => 'Admin privileges required']);
        exit();
    }

    if (!$book_id || !$isbn || !$title) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("UPDATE books SET isbn = ?, title = ?, author_id = ?, category_id = ?, publish_year = ? WHERE id = ?");
        $stmt->execute([$isbn, $title, $author_id, $category_id, $publish_year, $book_id]);
        
        echo json_encode(['success' => true, 'message' => 'Book updated successfully']);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['success' => false, 'message' => 'ISBN already exists for another book']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }
}
?>
