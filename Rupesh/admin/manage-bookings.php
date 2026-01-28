<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $booking_id = (int)$_GET['id'];
    $new_status = '';

    if ($action == 'confirm') $new_status = 'confirmed';
    if ($action == 'cancel') $new_status = 'cancelled';

    if ($new_status) {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
        if ($stmt->execute([$new_status, $booking_id])) {
            redirect('manage-bookings.php', "Request Status Updated: " . ucfirst($new_status));
        }
    }
}

$stmt = $pdo->query("
    SELECT b.*, v.brand, u.name as user_name, u.email as user_email 
    FROM bookings b 
    JOIN vehicles v ON b.vehicle_id = v.vehicle_id 
    JOIN users u ON b.user_id = u.user_id 
    ORDER BY b.booking_date DESC
");
$bookings = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<div class="container" style="padding-top: var(--space-lg); padding-bottom: var(--space-lg);">
    <div class="section-label">Operations Control</div>
    <h1 class="admin-title">Fleet Rental<br>Authority.</h1>

    <div class="table-responsive">
        <table class="clean-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Member</th>
                    <th>Model</th>
                    <th>Duration</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td data-label="Reference" style="font-size: 0.75rem; color: #999;">#<?php echo $b['booking_id']; ?></td>
                        <td data-label="Member">
                            <div style="font-weight: 800; text-transform: uppercase;"><?php echo $b['user_name']; ?></div>
                            <div style="font-size: 0.7rem; color: #666;"><?php echo $b['user_email']; ?></div>
                        </td>
                        <td data-label="Model" style="font-weight: 800; text-transform: uppercase;"><?php echo $b['brand']; ?></td>
                        <td data-label="Duration">
                            <div style="font-size: 0.8rem;">
                                <?php echo date('M d', strtotime($b['start_date'])); ?> — 
                                <?php echo date('M d, Y', strtotime($b['end_date'])); ?>
                            </div>
                        </td>
                        <td data-label="Cost" style="font-weight: 900;"><?php echo formatCurrency($b['total_cost']); ?></td>
                        <td data-label="Status">
                            <span style="font-size: 0.6rem; font-weight: 900; letter-spacing: 1px; text-transform: uppercase;">
                                <?php echo $b['status']; ?>
                            </span>
                        </td>
                        <td data-label="Action">
                            <?php if ($b['status'] == 'pending'): ?>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="manage-bookings.php?action=confirm&id=<?php echo $b['booking_id']; ?>" 
                                       class="btn-cta" style="padding: 0.5rem 1rem; font-size: 0.6rem;">Authorize</a>
                                    <a href="manage-bookings.php?action=cancel&id=<?php echo $b['booking_id']; ?>" 
                                       class="btn-cta" style="padding: 0.5rem 1rem; font-size: 0.6rem; background: #999;">Decline</a>
                                </div>
                            <?php else: ?>
                                <span style="font-size: 0.65rem; font-weight: 800; color: #ccc; text-transform: uppercase;">Closed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<section style="height: 10vh;"></section>

<?php require_once '../includes/footer.php'; ?>
