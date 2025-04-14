<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

$page_title = "Report a Disaster";
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $type = $_POST['type'];
    $severity = $_POST['severity'];
    
    if (empty($title) || empty($description) || empty($location)) {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            // Start transaction
            $pdo->beginTransaction();
            
            // Insert disaster report
            $stmt = $pdo->prepare("INSERT INTO disasters (user_id, title, description, location, type, severity) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $title, $description, $location, $type, $severity]);
            $disaster_id = $pdo->lastInsertId();
            
            // Get user information
            $user_stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
            $user_stmt->execute([$_SESSION['user_id']]);
            $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
            
            // Prepare disaster data for email
            $disasterData = [
                'id' => $disaster_id,
                'title' => $title,
                'type' => $type,
                'severity' => $severity,
                'location' => $location,
                'description' => $description
            ];
            
            // Try to send email (using PHPMailer if available, fallback to mail())
            $mailSent = false;
            if (function_exists('sendDisasterReportEmail')) {
                $mailSent = sendDisasterReportEmail($disasterData, $user);
            } else {
                // Fallback to basic mail() function
                $to = ADMIN_EMAIL;
                $subject = "New Disaster Report: " . htmlspecialchars($title);
                $message = "A new disaster has been reported:\n\n";
                $message .= "Title: $title\n";
                $message .= "Type: " . ucfirst($type) . "\n";
                $message .= "Location: $location\n";
                $message .= "Severity: " . ucfirst($severity) . "\n";
                $message .= "Description:\n$description\n\n";
                $message .= "Reported by: {$user['username']} ({$user['email']})\n";
                $message .= "Reported at: " . date('F j, Y \a\t g:i A') . "\n";
                
                $headers = "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
                $headers .= "Reply-To: " . $user['email'] . "\r\n";
                $headers .= "X-Priority: 1\r\n";
                
                $mailSent = mail($to, $subject, $message, $headers);
            }
            
            if ($mailSent) {
                $pdo->commit();
                $success = 'Your disaster report has been submitted successfully. The admin has been notified.';
                // Clear form
                $_POST = [];
            } else {
                $pdo->rollBack();
                $error = 'Report submitted but failed to send notification email. Please contact admin.';
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = 'Failed to submit report. Please try again. Error: ' . $e->getMessage();
        }
    }
}

require_once 'includes/header.php';
?>

<section class="report-form">
    <h2><i class="fas fa-plus-circle"></i> Report a Disaster</h2>
    
    <?php if ($success): ?>
        <div class="alert success">
            <i class="fas fa-check-circle"></i>
            <p><?php echo htmlspecialchars($success); ?></p>
        </div>
    <?php elseif ($error): ?>
        <div class="alert error">
            <i class="fas fa-exclamation-circle"></i>
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>
    
    <form action="report.php" method="post">
        <div class="form-group">
            <label for="title"><i class="fas fa-heading"></i> Disaster Title:</label>
            <input type="text" id="title" name="title" required 
                   value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="type"><i class="fas fa-tag"></i> Disaster Type:</label>
                <select id="type" name="type" required>
                    <option value="">Select a type</option>
                    <option value="earthquake" <?php echo (isset($_POST['type']) && $_POST['type'] === 'earthquake') ? 'selected' : ''; ?>>Earthquake</option>
                    <option value="flood" <?php echo (isset($_POST['type']) && $_POST['type'] === 'flood') ? 'selected' : ''; ?>>Flood</option>
                    <option value="hurricane" <?php echo (isset($_POST['type']) && $_POST['type'] === 'hurricane') ? 'selected' : ''; ?>>Hurricane</option>
                    <option value="wildfire" <?php echo (isset($_POST['type']) && $_POST['type'] === 'wildfire') ? 'selected' : ''; ?>>Wildfire</option>
                    <option value="tsunami" <?php echo (isset($_POST['type']) && $_POST['type'] === 'tsunami') ? 'selected' : ''; ?>>Tsunami</option>
                    <option value="other" <?php echo (isset($_POST['type']) && $_POST['type'] === 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="severity"><i class="fas fa-bolt"></i> Severity:</label>
                <select id="severity" name="severity" required>
                    <option value="">Select severity</option>
                    <option value="low" <?php echo (isset($_POST['severity']) && $_POST['severity'] === 'low') ? 'selected' : ''; ?>>Low</option>
                    <option value="medium" <?php echo (isset($_POST['severity']) && $_POST['severity'] === 'medium') ? 'selected' : ''; ?>>Medium</option>
                    <option value="high" <?php echo (isset($_POST['severity']) && $_POST['severity'] === 'high') ? 'selected' : ''; ?>>High</option>
                    <option value="extreme" <?php echo (isset($_POST['severity']) && $_POST['severity'] === 'extreme') ? 'selected' : ''; ?>>Extreme</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="location"><i class="fas fa-map-marker-alt"></i> Location:</label>
            <input type="text" id="location" name="location" required 
                   value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="description"><i class="fas fa-align-left"></i> Description:</label>
            <textarea id="description" name="description" rows="6" required><?php 
                echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; 
            ?></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-large">
                <i class="fas fa-paper-plane"></i> Submit Report
            </button>
            <a href="disasters.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</section>

<?php require_once 'includes/footer.php'; ?>