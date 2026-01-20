<?php require 'db.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Fitness Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="top-bar">
        <h2>Membership Dashboard</h2>
        <a href="index.php" class="link-button">+ Add New Member</a>
    </div>

    <?php
    try {
        $stmt = $conn->query("SELECT id, member_name, email, plan_type, duration_months, joined_at FROM Gymmembers ORDER BY joined_at DESC");
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<p>Error fetching members: " . htmlspecialchars($e->getMessage()) . "</p>";
        $members = [];
    }
    ?>

    <?php if (count($members) === 0): ?>
        <p>No members found. <a href="index.php">Create the first membership</a>.</p>
    <?php else: ?>
        <div class="table-wrapper">
            <table class="simple-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Duration (months)</th>
                        <th>Joined At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $index => $member): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($member['member_name']); ?></td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td><?php echo htmlspecialchars($member['plan_type']); ?></td>
                            <td><?php echo (int)$member['duration_months']; ?></td>
                            <td><?php echo htmlspecialchars($member['joined_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>


