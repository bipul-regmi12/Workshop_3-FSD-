<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $theme = $_POST['theme'];
    setcookie('theme', $theme, time() + 86400 * 30);
    header("Location: preference.php");
    exit();
}

$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Preferences</title>
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
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            <?php if ($theme == 'dark'): ?>
                background-color: #2d2d2d;
            <?php else: ?>
                background-color: #ffffff;
            <?php endif; ?>
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            <?php if ($theme == 'dark'): ?>
                background-color: #404040;
                color: #ffffff;
            <?php else: ?>
                background-color: #ffffff;
                color: #333333;
            <?php endif; ?>
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #FF9800;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 15px;
        }

        button:hover {
            background-color: #e68900;
        }

        a {
            display: block;
            text-align: center;
            <?php if ($theme == 'dark'): ?>
                color: #4da6ff;
            <?php else: ?>
                color: #2196F3;
            <?php endif; ?>
            text-decoration: none;
            margin-top: 15px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Theme Preferences</h2>
        <form method="POST">
            <label>Select Theme:</label>
            <select name="theme">
                <option value="light" <?php if ($theme == 'light')
                    echo 'selected'; ?>>Light Mode</option>
                <option value="dark" <?php if ($theme == 'dark')
                    echo 'selected'; ?>>Dark Mode</option>
            </select>
            <button type="submit">Save</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>

</html>