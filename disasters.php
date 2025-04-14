<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Get all disasters
$stmt = $pdo->query("SELECT d.*, u.username FROM disasters d JOIN users u ON d.user_id = u.id ORDER BY reported_at DESC");
$disasters = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="disaster-list">
    <h2>Recent Disasters</h2>
    
    <div class="search-filter">
        <input type="text" id="search" placeholder="Search disasters...">
        <select id="type-filter">
            <option value="">All Types</option>
            <option value="earthquake">Earthquake</option>
            <option value="flood">Flood</option>
            <option value="hurricane">Hurricane</option>
            <option value="wildfire">Wildfire</option>
            <option value="tsunami">Tsunami</option>
            <option value="other">Other</option>
        </select>
        <select id="severity-filter">
            <option value="">All Severities</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
            <option value="extreme">Extreme</option>
        </select>
    </div>
    
    <div class="disaster-grid">
        <?php foreach ($disasters as $disaster): ?>
            <div class="disaster-card" data-type="<?php echo $disaster['type']; ?>" data-severity="<?php echo $disaster['severity']; ?>">
                <h3><?php echo htmlspecialchars($disaster['title']); ?></h3>
                <p class="disaster-type <?php echo strtolower($disaster['type']); ?>">
                    <?php echo ucfirst($disaster['type']); ?>
                </p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($disaster['location']); ?></p>
                <p><strong>Severity:</strong> <?php echo ucfirst($disaster['severity']); ?></p>
                <p><strong>Reported by:</strong> <?php echo htmlspecialchars($disaster['username']); ?></p>
                <p><?php echo htmlspecialchars($disaster['description']); ?></p>
                <p class="disaster-date">Reported on: <?php echo date('M j, Y H:i', strtotime($disaster['reported_at'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (isLoggedIn()): ?>
        <div class="action-buttons">
            <a href="report.php" class="btn">Report New Disaster</a>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>