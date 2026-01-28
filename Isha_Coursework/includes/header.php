<?php
// includes/header.php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found Management</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">
                <i class="fa-solid fa-magnifying-glass-location"></i> Lost<b>&</b>Found
            </a>
            <div class="nav-links">
                <?php if (isLoggedIn()): ?>
                    <a href="index.php" class="nav-item">Dashboard</a>
                    <a href="add.php" class="nav-item">Report Item</a>
                    <div class="user-menu">
                        <span class="username"><i class="fa-regular fa-user"></i> <?php echo h($_SESSION['username']); ?></span>
                        <a href="logout.php" class="btn btn-secondary btn-sm">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="nav-item">Login</a>
                    <a href="register.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="main-content">
