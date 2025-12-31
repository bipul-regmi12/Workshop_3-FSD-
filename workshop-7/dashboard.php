<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            <?php if ($theme == 'dark'): ?>
                background-color: #1a1a1a;
                color: #ffffff;
            <?php else: ?>
                background-color: #f4f4f4;
                color: #333333;
            <?php endif; ?>
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        nav {
            text-align: center;
            padding: 20px;
            <?php if ($theme == 'dark'): ?>
                background-color: #2d2d2d;
            <?php else: ?>
                background-color: #ffffff;
            <?php endif; ?>
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        nav a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
            <?php if ($theme == 'dark'): ?>
                color: #ffffff;
                background-color: #404040;
            <?php else: ?>
                color: #333333;
                background-color: #e0e0e0;
            <?php endif; ?>
        }

        nav a:hover {
            <?php if ($theme == 'dark'): ?>
                background-color: #505050;
            <?php else: ?>
                background-color: #d0d0d0;
            <?php endif; ?>
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Welcome to Dashboard</h2>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="preference.php">Preferences</a>
            <a href="dashboard.php?logout=true">Logout</a>
        </nav>
    </div>
</body>

</html>