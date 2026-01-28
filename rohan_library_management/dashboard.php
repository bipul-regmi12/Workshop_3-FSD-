<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}

$user_role = $_SESSION['role'];
$username = $_SESSION['username'];

// Fetch some initial stats
$totalBooks = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
$availableBooks = $pdo->query("SELECT COUNT(*) FROM books WHERE status = 'Available'")->fetchColumn();
$totalAuthors = $pdo->query("SELECT COUNT(*) FROM authors")->fetchColumn();

// Fetch initial books
$booksStmt = $pdo->query("SELECT b.*, a.author_name, c.category_name FROM books b 
                         LEFT JOIN authors a ON b.author_id = a.id 
                         LEFT JOIN categories c ON b.category_id = c.id 
                         LIMIT 10");
$books = $booksStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | LuminaLib LMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        // Apply theme immediately to prevent flashing
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
                <li><a href="dashboard.php" class="active">📊 Dashboard</a></li>
                <li><a href="catalog.php">📚 Books Catalog</a></li>
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

        <!-- Main Content -->
        <main>
            <header>
                <div>
                    <h1 style="font-size: 1.875rem; margin-bottom: 0.25rem;">Control Center</h1>
                    <p style="color: var(--text-muted);">Manage and monitor library assets in real-time.</p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button id="searchBtn" class="btn" style="background: white; border: 1px solid var(--border); box-shadow: var(--shadow);">
                        🔍 Advanced Search
                    </button>
                    <?php if ($user_role === 'Admin'): ?>
                        <button class="btn btn-primary" id="addBookBtn">➕ Add New Book</button>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Books</h3>
                    <div class="value">--</div>
                </div>
                <div class="stat-card">
                    <h3>Available</h3>
                    <div class="value" style="color: var(--success);">--</div>
                </div>
                <div class="stat-card">
                    <h3>Authors</h3>
                    <div class="value">--</div>
                </div>
                <div class="stat-card">
                    <h3>Active Borrowers</h3>
                    <div class="value">--</div>
                </div>
            </div>

            <!-- Data Visualization -->
            <div class="charts-container">
                <div class="chart-card">
                    <h2 style="font-size: 1.125rem;">Genre Distribution</h2>
                    <div id="genreChart" class="bar-chart">
                        <div style="text-align: center; color: var(--text-muted); padding: 1rem;">Loading analytics...</div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 1.125rem;">Recent Acquisitions</h2>
                    <span style="font-size: 0.875rem; color: var(--text-muted);">Showing live library data</span>
                </div>
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

    <!-- Search Sidebar -->
    <div id="search-sidebar">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3>Filter Library</h3>
            <button id="closeSearch" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Title / ISBN</label>
                <input type="text" id="searchInput" placeholder="Search keyword..." style="width: 100%;">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Category</label>
                <select id="categoryFilter" style="width: 100%;">
                    <option value="">All Categories</option>
                    <!-- Will be populated via JS -->
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; margin-bottom: 0.5rem;">Publication Year Range</label>
                <input type="range" id="yearRange" min="1900" max="2025" value="2025" style="width: 100%; accent-color: var(--accent);">
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-muted);">
                    <span>1900</span>
                    <span id="yearValue">2025</span>
                </div>
            </div>
            <button id="applyFilters" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">Apply Filters</button>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div id="bookModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 3000; align-items: center; justify-content: center;">
        <div class="auth-card" style="max-width: 500px; padding: 2rem;">
            <h3 id="modalTitle" style="margin-bottom: 1.5rem;">Add New Book</h3>
            <form id="bookForm">
                <input type="hidden" name="book_id" id="modalBookId">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; margin-bottom: 0.4rem;">ISBN</label>
                        <input type="text" name="isbn" required style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; margin-bottom: 0.4rem;">Title</label>
                        <input type="text" name="title" required style="width: 100%;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; margin-bottom: 0.4rem;">Author</label>
                        <select id="authorSelect" name="author_id" required style="width: 100%;"></select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; margin-bottom: 0.4rem;">Category</label>
                        <select id="categorySelect" name="category_id" required style="width: 100%;"></select>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; margin-bottom: 0.4rem;">Publish Year</label>
                    <input type="number" name="publish_year" value="2024" required style="width: 100%;">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="button" id="cancelBook" class="btn" style="flex: 1; border: 1px solid var(--border);">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">Save Book</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">Action completed successfully!</div>

    <script src="assets/js/app.js"></script>
</body>
</html>
