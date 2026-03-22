<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
redirectIfNotAdmin();

// Get all disasters
$stmt = $pdo->query("SELECT d.*, u.username FROM disasters d JOIN users u ON d.user_id = u.id ORDER BY reported_at DESC");
$disasters = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<h2>Admin Dashboard</h2>

<div class="admin-actions">
    <a href="#" class="btn">Add Emergency Contact</a>
    <a href="#" class="btn">Manage Users</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Location</th>
            <th>Severity</th>
            <th>Reported By</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($disasters as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d['title']) ?></td>
            <td><?= htmlspecialchars($d['type']) ?></td>
            <td><?= htmlspecialchars($d['location']) ?></td>
            <td><?= htmlspecialchars($d['severity']) ?></td>
            <td><?= htmlspecialchars($d['username']) ?></td>
            <td><?= date('Y-m-d', strtotime($d['reported_at'])) ?></td>
            <td><?= htmlspecialchars($d['status'] ?? 'Pending') ?></td>
            <td><a href="#">Edit</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>