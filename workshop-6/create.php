<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        include 'db.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stmt = $pdo->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['name'], $_POST['email'], $_POST['course']]);
            header("Location: index.php");
        }
        ?>
        <h2>Add New Student</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="course" placeholder="Course" required><br>
            <button type="submit">Add Student</button>
        </form>
        <br>
        <a href="index.php">Back to List</a>
    </div>
</body>

</html>