<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Get emergency contacts
$stmt = $pdo->query("SELECT * FROM emergency_contacts ORDER BY region, organization");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group contacts by region
$contacts_by_region = [];
foreach ($contacts as $contact) {
    $contacts_by_region[$contact['region']][] = $contact;
}
?>

<section class="emergency-contacts">
    <h2>Emergency Contacts</h2>
    
    <div class="contact-search">
        <input type="text" id="contact-search" placeholder="Search contacts...">
    </div>
    
    <?php foreach ($contacts_by_region as $region => $region_contacts): ?>
        <div class="contact-region">
            <h3><?php echo htmlspecialchars($region); ?></h3>
            <div class="contact-grid">
                <?php foreach ($region_contacts as $contact): ?>
                    <div class="contact-card">
                        <h4><?php echo htmlspecialchars($contact['organization']); ?></h4>
                        <p><strong><?php echo htmlspecialchars($contact['name']); ?></strong></p>
                        <p>Phone: <a href="tel:<?php echo htmlspecialchars($contact['phone']); ?>"><?php echo htmlspecialchars($contact['phone']); ?></a></p>
                        <?php if (!empty($contact['email'])): ?>
                            <p>Email: <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"><?php echo htmlspecialchars($contact['email']); ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    
    <div class="global-contacts">
        <h3>Global Emergency Numbers</h3>
        <ul>
            <li><strong>International Emergency Number:</strong> 112 (in most countries)</li>
            <li><strong>Red Cross:</strong> Varies by country</li>
            <li><strong>UN Disaster Relief:</strong> +41 22 917 1234</li>
        </ul>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>