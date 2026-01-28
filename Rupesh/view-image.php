<?php
require_once __DIR__ . '/includes/config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image FROM vehicles WHERE vehicle_id = ?");
    $stmt->execute([$id]);
    $vehicle = $stmt->fetch();

    if ($vehicle && $vehicle['image']) {
        // Simple heuristic to detect image type, or just serve as jpeg/png
        // Since we are using LONGBLOB, we should ideally store the mime type too, 
        // but for now we'll send a generic image header
        header("Content-Type: image/jpeg"); 
        echo $vehicle['image'];
        exit();
    }
}

// Fallback to placeholder if no image found in DB
header("Location: https://placehold.co/600x400/1e293b/f8fafc?text=No+Image");
exit();
?>
