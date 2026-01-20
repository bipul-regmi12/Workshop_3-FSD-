<?php
//database connection file
require_once 'db_config.php';

$total_products = 0;
$all_products = array();
$error_message = "";

try {

    $sql = "SELECT COUNT(*) as total FROM product";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_products = $row['total'];

    // Get 5 most recent products
    $sql2 = "SELECT * FROM product ORDER BY created_at DESC LIMIT 5";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $all_products = $stmt2->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error_message = "Database Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f6f7f9;
            color: #222;
            padding: 24px;
        }

        /* Headings */
        h1,
        h2,
        h3 {
            font-weight: 600;
            margin-bottom: 12px;
        }

        /* Navbar */
        .navbar {
            max-width: 900px;
            margin: 0 auto 24px;
            display: flex;
            gap: 16px;
        }

        .navbar a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
        }

        .navbar a:hover {
            color: #000;
        }

        /* Main content */
        .content {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        /* Error message */
        .error {
            background: #fff1f1;
            border-left: 4px solid #e5533d;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* Stats box */
        .stats-box {
            padding: 16px;
            border: 1px solid #e4e6eb;
            border-radius: 6px;
            margin-bottom: 24px;
        }

        .stats-box p {
            font-size: 28px;
            font-weight: 700;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th {
            text-align: left;
            font-weight: 600;
            padding: 12px;
            border-bottom: 2px solid #e4e6eb;
            color: #555;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e4e6eb;
        }

        tr:hover {
            background: #fafafa;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            color: #777;
            padding: 20px;
        }

        /* Links */
        a {
            color: #0066cc;
        }

        /* Forms (kept minimal for future pages) */
        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e4e6eb;
            border-radius: 4px;
            font-size: 14px;
        }

        button,
        input[type="submit"] {
            background: #111;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover,
        input[type="submit"]:hover {
            background: #000;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="inventory.php">Add Product</a>
    </div>


    <div class="content">
        <h1>Inventory Dashboard</h1>

        <!-- Show error  -->
        <?php if ($error_message != ""): ?>
            <div class="error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Statistics Box -->
        <div class="stats-box">
            <h3>Total Products</h3>
            <p><?php echo $total_products; ?></p>
        </div>

        <!-- Products Table -->
        <div class="products-table">
            <h2> 5 Most Recent Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Supplier</th>
                        <th>Description</th>
                        <th>Added Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($all_products) > 0) {
                        foreach ($all_products as $product) {
                            // Format date as DD-MM-YYYY
                            $formatted_date = date('d-m-Y', strtotime($product['created_at']));

                            echo "<tr>";
                            echo "<td><strong>#" . $product['id'] . "</strong></td>";
                            echo "<td class='product-name'>" . htmlspecialchars($product['product_name']) . "</td>";
                            echo "<td class='supplier'>" . htmlspecialchars($product['supplier_name']) . "</td>";
                            echo "<td class='description'>" . htmlspecialchars($product['item_description']) . "</td>";
                            echo "<td><span class='date-badge'>" . $formatted_date . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='empty-state'>No products found. Add some products first!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>