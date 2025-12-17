<?php include 'header.php'; ?>

<h2>Registered Students</h2>

<?php
$file = 'students.txt';

if (file_exists($file)) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (!empty($lines)) {
        echo "<ul>";
        foreach ($lines as $line) {
            $student = json_decode($line, true);
            if ($student) {
                echo "<li>";
                echo "<strong>Name:</strong> " . htmlspecialchars($student['name']) . "<br>";
                echo "<strong>Email:</strong> " . htmlspecialchars($student['email']) . "<br>";
                echo "<strong>Skills:</strong> " . implode(", ", array_map('htmlspecialchars', $student['skills']));
                echo "</li><br>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>No students found.</p>";
    }
} else {
    echo "<p>No student records found.</p>";
}
?>

<?php include 'footer.php'; ?>