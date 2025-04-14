<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

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
        <?