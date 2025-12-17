<?php
require_once 'functions.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = formatName($_POST['name'] ?? '');
        $email = validateEmail($_POST['email'] ?? '');
        $skills = cleanSkills($_POST['skills'] ?? '');

        saveStudent($name, $email, $skills);
        $message = "<div class='message success'>Student saved successfully!</div>";
    } catch (Exception $e) {
        $message = "<div class='message error'>Error: " . $e->getMessage() . "</div>";
    }
}

include 'header.php';
?>

<h2>Add Student Info</h2>
<?php echo $message; ?>

<form action="add_student.php" method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Skills (comma-separated):</label><br>
    <input type="text" name="skills" placeholder="PHP, HTML, CSS"><br><br>

    <button type="submit">Save Student</button>
</form>

<?php include 'footer.php'; ?>