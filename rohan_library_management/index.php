<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT u.*, r.role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role_name'];
        redirect('dashboard.php');
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LuminaLib LMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body class="auth-wrapper">
    <div class="auth-card">
        <div class="brand" style="justify-content: center; margin-bottom: 2rem;">
            <span>✨ LuminaLib</span>
        </div>
        <button id="themeToggle" class="theme-toggle" style="margin: 0 auto 2rem; display: flex;">🌓</button>
        <h2 style="text-align: center; margin-bottom: 0.5rem;">Welcome Back</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Please enter your details</p>
        
        <?php if ($error): ?>
            <div style="background: #FEE2E2; color: #EF4444; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Username</label>
                <input type="text" name="username" placeholder="e.g. admin" required style="width: 100%;">
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Password</label>
                <input type="password" name="password" placeholder="••••••••" required style="width: 100%;">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Sign In</button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: var(--text-muted);">
            Demo: admin / password123
        </p>
    </div>
    <div id="toast" class="toast"></div>
    <script src="assets/js/app.js"></script>
</body>
</html>
