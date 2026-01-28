<?php
// public/index.php
require_once '../config/db.php';
require_once '../includes/functions.php';

requireLogin();

// Fetch all items initially (limit to recent 20 for performance)
$stmt = $pdo->query("SELECT i.*, u.username FROM items i JOIN users u ON i.user_id = u.id ORDER BY i.date_reported DESC LIMIT 20");
$items = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<div class="page-header fade-in">
    <div class="page-title">
        <h1>Dashboard</h1>
        <p style="color: var(--text-gray);">Manage reported items and status</p>
    </div>
    <a href="add.php" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Report Item
    </a>
</div>

<div class="card fade-in">
    <div class="card-header">
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Search items, categories, or descriptions..." autocomplete="off">
            <div id="suggestions" class="suggestions-box"></div>
        </div>
        <div style="display: flex; gap: 1rem;">
            <select class="form-control" id="filterStatus" style="width: auto; padding: 0.5rem 1rem;">
                <option value="">All Status</option>
                <option value="lost">Lost</option>
                <option value="found">Found</option>
                <option value="claimed">Claimed</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table" id="itemsTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reporter</th>
                    <th>Item Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo date('M d, Y', strtotime($item['date_reported'])); ?></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 24px; height: 24px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;">
                                <?php echo strtoupper(substr($item['username'], 0, 1)); ?>
                            </div>
                            <?php echo h($item['username']); ?>
                        </div>
                    </td>
                    <td>
                        <strong><?php echo h($item['item_name']); ?></strong>
                        <div style="font-size: 0.8rem; color: var(--text-gray); margin-top: 0.2rem;"><?php echo h(substr($item['description'], 0, 50)) . '...'; ?></div>
                    </td>
                    <td><i class="fa-solid fa-location-dot" style="color: var(--secondary);"></i> <?php echo h($item['location']); ?></td>
                    <td>
                        <span class="status-badge status-<?php echo h($item['status']); ?>">
                            <?php echo ucfirst(h($item['status'])); ?>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn btn-secondary btn-sm" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="delete.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($items)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 2rem;">No items found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const tableBody = document.getElementById('tableBody');
    const suggestions = document.getElementById('suggestions');

    function fetchResults() {
        const query = searchInput.value;
        const status = filterStatus.value;
        
        fetch(`search_ajax.php?q=${encodeURIComponent(query)}&status=${status}`)
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = '';
                
                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 2rem;">No items found.</td></tr>';
                    return;
                }

                data.forEach(item => {
                    const row = `
                        <tr class="fade-in">
                            <td>${new Date(item.date_reported).toLocaleDateString()}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 24px; height: 24px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: white;">
                                        ${item.username.charAt(0).toUpperCase()}
                                    </div>
                                    ${escapeHtml(item.username)}
                                </div>
                            </td>
                            <td>
                                <strong>${escapeHtml(item.item_name)}</strong>
                                <div style="font-size: 0.8rem; color: var(--text-gray); margin-top: 0.2rem;">${escapeHtml(item.description.substring(0, 50))}...</div>
                            </td>
                            <td><i class="fa-solid fa-location-dot" style="color: var(--secondary);"></i> ${escapeHtml(item.location)}</td>
                            <td>
                                <span class="status-badge status-${escapeHtml(item.status)}">
                                    ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="edit.php?id=${item.id}" class="btn btn-secondary btn-sm" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="delete.php?id=${item.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            });
    }

    // Live search (Advance feature 1)
    searchInput.addEventListener('input', function() {
        fetchResults();
        
        // Autocomplete suggestions (Advance feature 2)
        if (this.value.length > 1) {
            fetch(`search_ajax.php?q=${encodeURIComponent(this.value)}&type=names`)
                .then(res => res.json())
                .then(names => {
                    suggestions.innerHTML = '';
                    if (names.length > 0) {
                        suggestions.style.display = 'block';
                        names.slice(0, 5).forEach(n => {
                            const div = document.createElement('div');
                            div.className = 'suggestion-item';
                            div.textContent = n.item_name;
                            div.onclick = () => {
                                searchInput.value = n.item_name;
                                suggestions.style.display = 'none';
                                fetchResults();
                            };
                            suggestions.appendChild(div);
                        });
                    } else {
                        suggestions.style.display = 'none';
                    }
                });
        } else {
            suggestions.style.display = 'none';
        }
    });

    filterStatus.addEventListener('change', fetchResults);
    
    // Close suggestions on click outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.style.display = 'none';
        }
    });

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>
