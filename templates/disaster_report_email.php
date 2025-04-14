<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 0; }
        .header { background-color: #e74c3c; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .disaster-info { background-color: white; border: 1px solid #ddd; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .label { font-weight: bold; color: #2c3e50; display: inline-block; width: 120px; }
        .footer { margin-top: 20px; font-size: 0.9em; color: #7f8c8d; text-align: center; padding: 10px; }
        .btn { display: inline-block; background-color: #3498db; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-top: 10px; }
        .urgency-badge { background-color: #e74c3c; color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.8em; font-weight: bold; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>New Disaster Report</h2>
            <p><span class="urgency-badge">URGENT ATTENTION REQUIRED</span></p>
        </div>
        <div class='content'>
            <p>A new disaster has been reported in the Disaster Management System:</p>
            
            <div class='disaster-info'>
                <p><span class='label'>Report ID:</span> #<?php echo $disasterData['id']; ?></p>
                <p><span class='label'>Title:</span> <?php echo htmlspecialchars($disasterData['title']); ?></p>
                <p><span class='label'>Type:</span> <?php echo ucfirst($disasterData['type']); ?></p>
                <p><span class='label'>Severity:</span> <?php echo ucfirst($disasterData['severity']); ?></p>
                <p><span class='label'>Location:</span> <?php echo htmlspecialchars($disasterData['location']); ?></p>
                <p><span class='label'>Description:</span><br><?php echo nl2br(htmlspecialchars($disasterData['description'])); ?></p>
            </div>
            
            <p><span class='label'>Reported by:</span> <?php echo htmlspecialchars($userData['username']); ?> (<?php echo htmlspecialchars($userData['email']); ?>)</p>
            <p><span class='label'>Reported at:</span> <?php echo date('F j, Y \a\t g:i A'); ?></p>
            
            <p>Please review this report and take appropriate action.</p>
            
            <a href='<?php echo BASE_URL; ?>/admin/dashboard.php' class='btn'>View in Admin Dashboard</a>
        </div>
        <div class='footer'>
            <p>This is an automated message from the <?php echo SITE_NAME; ?>.</p>
            <p>Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>