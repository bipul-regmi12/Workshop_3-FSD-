<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}

$user_role = $_SESSION['role'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Logs | LuminaLib LMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside>
            <div class="brand">✨ LuminaLib</div>
            <button id="themeToggle" class="theme-toggle" title="Toggle Dark/Light Mode">🌓</button>
            <ul class="nav-links">
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="catalog.php">📚 Books Catalog</a></li>
                <?php if ($user_role === 'Admin'): ?>
                    <li><a href="authors.php">✍️ Authors</a></li>
                    <li><a href="categories.php">📁 Categories</a></li>
                    <li><a href="logs.php" class="active">👤 User Logs</a></li>
                <?php endif; ?>
            </ul>
            <div style="margin-top: auto; padding-top: 2rem; border-top: 1px solid var(--border);">
                <!-- Profile section same as others -->
                 <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <div style="width: 40px; height: 40px; background: var(--accent); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                        <?= strtoupper(substr($username, 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 0.875rem;"><?= $username ?></div>
                        <div style="color: var(--text-muted); font-size: 0.75rem;"><?= $user_role ?></div>
                    </div>
                </div>
                <a href="logout.php" class="btn" style="width: 100%; border: 1px solid var(--border); background: white;">Logout</a>
            </div>
        </aside>

        <main>
            <header>
                <div>
                    <h1 style="font-size: 1.875rem; margin-bottom: 0.25rem;">System Logs</h1>
                    <p style="color: var(--text-muted);">Monitor user activities and system events.</p>
                </div>
            </header>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-family: monospace; font-size: 0.8125rem;">2024-01-23 10:45:12</td>
                            <td style="font-weight: 600;">admin</td>
                            <td><span style="background: #DCFCE7; color: #15803d; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">Login Success</span></td>
                            <td style="color: var(--text-muted);">192.168.1.1</td>
                        </tr>
                        <tr>
                            <td style="font-family: monospace; font-size: 0.8125rem;">2024-01-23 11:02:45</td>
                            <td style="font-weight: 600;">admin</td>
                            <td><span style="background: #DBEAFE; color: #1e40af; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">Added Book: Foundation</span></td>
                            <td style="color: var(--text-muted);">192.168.1.1</td>
                        </tr>
                        <!-- Static for now as schema doesn't have logs table yet, but showing the UI -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <div id="toast" class="toast"></div>
    <script src="assets/js/app.js"></script>
</body>
</html>
