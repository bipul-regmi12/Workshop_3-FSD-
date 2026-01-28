<?php
// Configuration File
// Centralizes all settings and connects to the database

// Project Base URL
define('BASE_URL', '/Rupesh/'); // Set to '/Rupesh/' because the project is in a subfolder

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include Database Connection and Setup
// This will automatically create the DB and tables on the first run
$pdo = require_once __DIR__ . '/../database/db.php';

// Global error reporting (for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
