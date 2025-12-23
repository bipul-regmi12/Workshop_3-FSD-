<?php
require_once 'functions.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['portfolio'])) {
    try {
        $result = uploadPortfolioFile($_FILES['portfolio']);
        $message = "<div class='message success'>$result</div>";
    } catch (Exception $e) {
        $message = "<div class='message error'>Error: " . $e->getMessage() . "</div>";
    }
}

include 'header.php';
?>

<h2>Upload Portfolio File</h2>
<?php echo $message; ?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label>Select File (PDF, JPG, PNG - Max 2MB):</label><br>
    <input type="file" name="portfolio" required><br><br>
    <button type="submit">Upload</button>
</form>

<?php include 'footer.php'; ?>