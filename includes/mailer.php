<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function sendDisasterReportEmail($disasterData, $userData) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your mail';  // SMTP username
        $mail->Password   = 'password';     // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom('your mail', 'Disaster Management System');
        $mail->addAddress('your mail', 'Admin');  // Admin notification
        $mail->addReplyTo($userData['email'], $userData['username']);  // Reply to reporter
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = '🚨 New Disaster Report: ' . htmlspecialchars($disasterData['title']);
        $mail->Priority = 1; // Highest priority
        
        // Build email body
        $mail->Body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .header { background: #e74c3c; color: white; padding: 20px; }
                .content { padding: 20px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>New Disaster Report</h2>
            </div>
            <div class='content'>
                <p><strong>Title:</strong> ".htmlspecialchars($disasterData['title'])."</p>
                <p><strong>Type:</strong> ".ucfirst($disasterData['type'])."</p>
                <p><strong>Location:</strong> ".htmlspecialchars($disasterData['location'])."</p>
                <p><strong>Description:</strong><br>".nl2br(htmlspecialchars($disasterData['description']))."</p>
                <p>Reported by: ".htmlspecialchars($userData['username'])." (".htmlspecialchars($userData['email']).")</p>
            </div>
        </body>
        </html>
        ";
        
        // Plain text alternative
        $mail->AltBody = "New Disaster Report\n\n".
                         "Title: ".$disasterData['title']."\n".
                         "Type: ".$disasterData['type']."\n".
                         "Location: ".$disasterData['location']."\n".
                         "Description:\n".$disasterData['description']."\n\n".
                         "Reported by: ".$userData['username']." (".$userData['email'].")";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>