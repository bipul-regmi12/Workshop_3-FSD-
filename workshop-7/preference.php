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
            max-width: 700px;
            margin: 80px auto;
            padding: 40px;
            <?php if ($theme == 'dark'): ?>
                background-color: #000000;
                border: 3px solid #ffffff;
            <?php else: ?>
                background-color: #f5f5f5;
                border: 3px solid #000000;
            <?php endif; ?>
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            <?php if ($theme == 'dark'): ?>
                color: #ffffff;
            <?php else: ?>
                color: #000000;
            <?php endif; ?>
            font-weight: 700;
            font-size: 36px;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        form {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            <?php if ($theme == 'dark'): ?>
                color: #ffffff;
            <?php else: ?>
                color: #000000;
            <?php endif; ?>
        }

        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            font-family: Helvetica, Arial, sans-serif;
            <?php if ($theme == 'dark'): ?>
                background-color: #1a1a1a;
                color: #ffffff;
                border: 2px solid #ffffff;
            <?php else: ?>
                background-color: #ffffff;
                color: #000000;
                border: 2px solid #000000;
            <?php endif; ?>
        }

        select:focus {
            outline: none;
            border-color: #ff0000;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #ff0000;
            color: #ffffff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #cc0000;
        }

        a {
            display: block;
            text-align: left;
            color: #ff0000;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
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