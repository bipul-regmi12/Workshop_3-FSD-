<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Stock Entry</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Warehouse Stock Entry</h1>
            <button><a href="dashboard.php">Go to Dashboard</a></button>
        </header>

        <main>
            <form action="add_product.php" method="POST">
                <label for="product_name">Product Title:</label><br>
                <input type="text" id="product_name" name="product_name" required><br><br>

                <label for="supplier_name">Supplier Name:</label><br>
                <input type="text" id="supplier_name" name="supplier_name" required><br><br>

                <label for="item_description">Detailed Description:</label><br>
                <textarea id="item_description" name="item_description" rows="5" cols="40"></textarea><br><br>

                <button type="submit">Add Inventory</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2026 isha fsd exam</p>
    </div>
</body>

</html>