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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            <?php if ($theme == 'dark'): ?>
                background-color: #1a1a1a;
                color: #ffffff;
            <?php else: ?>
                background-color: #ffffff;
                color: #000000;
            <?php endif; ?>
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 60px 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            <?php if ($theme == 'dark'): ?>
                color: #ffffff;
            <?php else: ?>
                color: #000000;
            <?php endif; ?>
            font-weight: 700;
            font-size: 48px;
            letter-spacing: -2px;
            text-transform: uppercase;
        }

        nav {
            padding: 30px;
            <?php if ($theme == 'dark'): ?>
                background-color: #000000;
                border: 3px solid #ffffff;
            <?php else: ?>
                background-color: #f5f5f5;
                border: 3px solid #000000;
            <?php endif; ?>
            display: flex;
            gap: 20px;
            justify-content: space-evenly;
            align-items: center;
            flex-wrap: wrap;
        }

        nav a {
            text-decoration: none;
            padding: 15px 30px;
            transition: all 0.2s;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
            <?php if ($theme == 'dark'): ?>
                color: #ffffff;
                background-color: #ff0000;
                border: 2px solid #ff0000;
            <?php else: ?>
                color: #ffffff;
                background-color: #ff0000;
                border: 2px solid #ff0000;
            <?php endif; ?>
        }

        nav a:hover {
            <?php if ($theme == 'dark'): ?>
                background-color: #ffffff;
                color: #000000;
                border-color: #ffffff;
            <?php else: ?>
                background-color: #000000;
                color: #ffffff;
                border-color: #000000;
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