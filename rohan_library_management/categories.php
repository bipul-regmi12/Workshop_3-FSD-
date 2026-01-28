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
    <title>Manage Categories | LuminaLib LMS</title>
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
                    <li><a href="categories.php" class="active">📁 Categories</a></li>
                    <li><a href="logs.php">👤 User Logs</a></li>
                <?php endif; ?>
            </ul>
            <div style="margin-top: auto; padding-top: 2rem; border-top: 1px solid var(--border);">
                <!-- User Profile Info -->
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
                    <h1 style="font-size: 1.875rem; margin-bottom: 0.25rem;">Categories Management</h1>
                    <p style="color: var(--text-muted);">Organize library assets by genres and categories.</p>
                </div>
                <?php if ($user_role === 'Admin'): ?>
                <button class="btn btn-primary" id="addCategoryBtn">➕ Add Category</button>
                <?php endif; ?>
            </header>

            <div class="table-container" style="max-width: 800px;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <!-- Populated via AJAX -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Add Category Modal -->
    <div id="categoryModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 3000; align-items: center; justify-content: center;">
        <div class="auth-card" style="max-width: 400px; padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Add New Category</h3>
            <form id="categoryForm">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.4rem;">Category Name</label>
                    <input type="text" name="category_name" required style="width: 100%;">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="button" id="cancelCategory" class="btn" style="flex: 1; border: 1px solid var(--border);">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script src="assets/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tableBody = document.getElementById('categoriesTableBody');
            const modal = document.getElementById('categoryModal');
            const form = document.getElementById('categoryForm');
            const toast = document.getElementById('toast');

            const showToast = (message, type = 'success') => {
                toast.textContent = message;
                toast.style.display = 'block';
                toast.style.background = type === 'success' ? '#1E293B' : '#EF4444';
                setTimeout(() => toast.style.display = 'none', 3000);
            };

            const loadCategories = async () => {
                const res = await fetch('api/get_categories_detailed.php');
                const data = await res.json();
                if (data.success) {
                    tableBody.innerHTML = data.categories.map(c => `
                        <tr>
                            <td>${c.id}</td>
                            <td style="font-weight: 600;">${c.category_name}</td>
                            <td>
                                <button class="btn" style="padding: 0.4rem; background: #F8FAFC; border: 1px solid var(--border);">✏️</button>
                            </td>
                        </tr>
                    `).join('');
                }
            };

            document.getElementById('addCategoryBtn')?.addEventListener('click', () => {
                modal.style.display = 'flex';
            });

            document.getElementById('cancelCategory').addEventListener('click', () => {
                modal.style.display = 'none';
                form.reset();
            });

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const res = await fetch('api/save_category.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    showToast(data.message);
                    modal.style.display = 'none';
                    form.reset();
                    loadCategories();
                } else {
                    showToast(data.message, 'error');
                }
            });

            loadCategories();
        });
    </script>
</body>
</html>
