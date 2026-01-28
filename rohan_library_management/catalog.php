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
    <title>Books Catalog | LuminaLib LMS</title>
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
                <li><a href="catalog.php" class="active">📚 Books Catalog</a></li>
                <?php if ($user_role === 'Admin'): ?>
                    <li><a href="authors.php">✍️ Authors</a></li>
                    <li><a href="categories.php">📁 Categories</a></li>
                    <li><a href="logs.php">👤 User Logs</a></li>
                <?php endif; ?>
            </ul>
            <div style="margin-top: auto; padding-top: 2rem; border-top: 1px solid var(--border);">
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
                    <h1 style="font-size: 1.875rem; margin-bottom: 0.25rem;">Full Book Catalog</h1>
                    <p style="color: var(--text-muted);">Browse and manage all available assets.</p>
                </div>
            </header>

            <div class="table-container">
                <table id="booksTable">
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Populated via AJAX -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="toast" class="toast"></div>

    <script src="assets/js/app.js"></script>
</body>
</html>
