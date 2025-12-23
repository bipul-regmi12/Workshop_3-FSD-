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
        'skills' => $skillsArray,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Saving as JSON line for easy reading later
    $filename = __DIR__ . '/students.txt';

    // Check if directory is writable
    if (!is_writable(__DIR__)) {
        throw new Exception("Directory is not writable. Run: sudo chmod 775 " . __DIR__);
    }

    // Create file if it doesn't exist
    if (!file_exists($filename)) {
        if (file_put_contents($filename, '') === false) {
            throw new Exception("Failed to create data file. Check directory permissions.");
        }
        chmod($filename, 0666);
    }

    // Encode data
    $json = json_encode($data);
    if ($json === false) {
        throw new Exception("Failed to encode data to JSON.");
    }

    $line = $json . PHP_EOL;

    // Write to file
    if (file_put_contents($filename, $line, FILE_APPEND | LOCK_EX) === false) {
        throw new Exception("Failed to save student data. Check file permissions.");
    }
}

function uploadPortfolioFile($file)
{
    $targetDir = __DIR__ . "/uploads/";
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            throw new Exception("Failed to create uploads directory. Check permissions.");
        }
    }

    // Check if directory is writable
    if (!is_writable($targetDir)) {
        throw new Exception("Uploads directory is not writable.");
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