<?php include 'header.php'; ?>

<h2>Uploaded Portfolio Files</h2>

<?php
$uploadDir = __DIR__ . '/uploads/';

if (is_dir($uploadDir)) {
    $files = array_diff(scandir($uploadDir), array('.', '..'));
    
    if (!empty($files)) {
        echo "<ul>";
        foreach ($files as $file) {
            $filePath = $uploadDir . $file;
            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $fileSize = filesize($filePath);
            $fileSizeKB = round($fileSize / 1024, 2);
            $uploadTime = date("Y-m-d H:i:s", filemtime($filePath));
            
            echo "<li>";
            echo "<strong>File:</strong> " . htmlspecialchars($file) . "<br>";
            echo "<strong>Size:</strong> " . $fileSizeKB . " KB<br>";
            echo "<strong>Uploaded:</strong> " . $uploadTime . "<br>";
            
            // Show preview for images
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "<br><img src='uploads/" . htmlspecialchars($file) . "' alt='Preview' style='max-width: 300px; max-height: 300px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;'><br>";
            } elseif ($fileExtension === 'pdf') {
                echo "<br><a href='uploads/" . htmlspecialchars($file) . "' target='_blank' style='color: #4CAF50; text-decoration: none; font-weight: bold;'>📄 View PDF</a><br>";
            }
            
            echo "<br><a href='uploads/" . htmlspecialchars($file) . "' download style='color: #2c3e50; text-decoration: none;'>⬇️ Download</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No portfolio files found.</p>";
    }
} else {
    echo "<p>Uploads directory does not exist.</p>";
}
?>

<?php include 'footer.php'; ?>
