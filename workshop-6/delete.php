<?php
include 'db.php';
$stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
$stmt->execute([$_GET['id']]);
header("Location: index.php?deleted=true");
?>