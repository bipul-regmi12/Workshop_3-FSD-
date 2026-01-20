<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim and sanitize input
    $product_name = trim($_POST['product_name'] ?? '');
    $supplier_name = trim($_POST['supplier_name'] ?? '');
    $item_description = trim($_POST['item_description'] ?? '');

    // Validate required fields
    if (empty($product_name) || empty($supplier_name)) {
        echo "<script>
            alert('Error: Product name and supplier name are required!');
            window.location.href = 'inventory.php';
        </script>";
        exit();
    }

    try {
        $sql = "INSERT INTO product (product_name, supplier_name, item_description) VALUES (:product_name, :supplier_name, :item_description)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':item_description', $item_description);

        $stmt->execute();

        echo "<script>
            alert('Product added successfully!');
            window.location.href = 'dashboard.php';
        </script>";

    } catch (PDOException $e) {
        // Log the actual error for debugging (don't expose to user)
        error_log("Database Error: " . $e->getMessage());

        echo "<script>
            alert('Error: Failed to add product. Please try again.');
            window.location.href = 'inventory.php';
        </script>";
    }
} else {
    header("Location: inventory.php");
    exit();
}
?>