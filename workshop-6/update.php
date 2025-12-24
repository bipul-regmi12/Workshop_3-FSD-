<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        include 'db.php';
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stmt = $pdo->prepare("UPDATE students SET name=?, email=?, course=? WHERE id=?");
            $stmt->execute([$_POST['name'], $_POST['email'], $_POST['course'], $id]);
            header("Location: index.php");
        }
        ?>
        <h2>Update Student</h2>
        <form method="POST">
            <input type="text" name="name" value="<?= $student['name'] ?>" placeholder="Name" required><br>
            <input type="email" name="email" value="<?= $student['email'] ?>" placeholder="Email" required><br>
            <input type="text" name="course" value="<?= $student['course'] ?>" placeholder="Course" required><br>
            <button type="submit">Update</button>
        </form>
        <br>
        <a href="index.php">Back to List</a>
    </div>
</body>

</html>