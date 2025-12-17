<?php

function formatName($name)
{
    return ucwords(strtolower(trim($name)));
}

function validateEmail($email)
{
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format.");
    }
    return $email;
}

function cleanSkills($string)
{
    $skills = explode(',', $string);
    return array_filter(array_map('trim', $skills)); // Remove whitespace and empty entries
}

function saveStudent($name, $email, $skillsArray)
{
    $data = [
        'name' => $name,
        'email' => $email,
        'skills' => $skillsArray
    ];
    // Saving as JSON line for easy reading later
    $line = json_encode($data) . PHP_EOL;
    if (file_put_contents('students.txt', $line, FILE_APPEND) === false) {
        throw new Exception("Failed to save student data.");
    }
}

function uploadPortfolioFile($file)
{
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($file["name"]);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $fileSize = $file["size"];

    // Validate Type
    $allowedTypes = ['jpg', 'png', 'pdf'];
    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception("Invalid file type. Only JPG, PNG, and PDF allowed.");
    }

    // Validate Size (2MB = 2 * 1024 * 1024 bytes)
    if ($fileSize > 2097152) {
        throw new Exception("File is too large. Max size is 2MB.");
    }

    // Rename file
    $newFileName = uniqid() . "_" . str_replace(' ', '_', $fileName);
    $targetFilePath = $targetDir . $newFileName;

    if (!move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        throw new Exception("Error moving uploaded file.");
    }

    return "File uploaded successfully as " . $newFileName;
}
?>