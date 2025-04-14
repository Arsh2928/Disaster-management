<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$page_title = "Disaster Preparedness Home";
$recent_disasters = [];

try {
    $stmt = $pdo->query("SELECT d.*, u.username 
                         FROM disasters d 
                         JOIN users u ON d.user_id = u.id 
                         ORDER BY reported_at DESC 
                         LIMIT 3");
    $recent_disasters = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

require_once 'includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>Disaster Awareness and Preparedness</h1>
        <p>Empowering communities with knowledge and tools to effectively prepare for and respond to disasters.</p>
        <div class="hero-buttons">
            <?php if (!isLoggedIn()): ?>
                <a href="register.php" class="btn btn-large">Join Our Community</a>
            <?php else: ?>
                <a href="report.php" class="btn btn-large">Report a Disaster</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="recent-disasters">
    <h2><i class="fas fa-exclamation-triangle"></i> Recent Disasters</h2>
    
    <?php if (empty($recent_disasters)): ?>
        <div class="alert info">
            <i class="fas fa-info-circle"></i>
            <p>No recent disasters reported. Stay vigilant!</p>
        </div>
    <?php else: ?>
        <div class="disaster-grid">
            <?php foreach ($recent_disasters as $disaster): ?>
                <div class="disaster-card" data-type="<?php echo $disaster['type']; ?>" data-severity="<?php echo $disaster['severity']; ?>">
                    <h3><?php echo htmlspecialchars($disaster['title']); ?></h3>
                    <p class="disaster-type <?php echo strtolower($disaster['type']); ?>">
                        <?php echo ucfirst($disaster['type']); ?>
                    </p>
                    <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> <?php echo htmlspecialchars($disaster['location']); ?></p>
                    <p><strong><i class="fas fa-bolt"></i> Severity:</strong> <?php echo ucfirst($disaster['severity']); ?></p>
                    <p><?php echo htmlspecialchars(substr($disaster['description'], 0, 100)); ?>...</p>
                    <p class="disaster-date"><i class="far fa-clock"></i> Reported on: <?php echo date('M j, Y', strtotime($disaster['reported_at'])); ?></p>
                    <p class="reported-by"><i class="fas fa-user"></i> Reported by: <?php echo htmlspecialchars($disaster['username']); ?></p>
                    <a href="disasters.php?id=<?php echo $disaster['id']; ?>" class="btn btn-small">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="text-center">
        <a href="disasters.php" class="btn">View All Disasters</a>
    </div>
</section>

<section class="features">
    <h2><i class="fas fa-shield-alt"></i> How We Help</h2>
    
    <div class="feature-grid">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <h3>Knowledge Base</h3>
            <p>Comprehensive information about different types of disasters and how to prepare for them.</p>
            <a href="knowledge.php" class="btn btn-small">Learn More</a>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h3>Emergency Contacts</h3>
            <p>Quick access to important contact information for emergency services in your area.</p>
            <a href="contacts.php" class="btn btn-small">View Contacts</a>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h3>Report Disasters</h3>
            <p>Help your community by reporting disasters in your area in real-time.</p>
            <a href="report.php" class="btn btn-small">Report Now</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>