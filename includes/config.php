<?php
session_start();

// Database configuration
define('DB_HOST', 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com;port=4000');
define('DB_NAME', 'test');
define('DB_USER', '2tGN85HQqGriFU6.root');
define('DB_PASS', 'fWg2s6o5EGjMbmT7');

// Email configuration
define('ADMIN_EMAIL', 'arshdeep17022005@gmail.com');
define('SITE_NAME', 'Disaster Management System');
define('SITE_EMAIL', 'arshdeep17022005@gmail.com');
if (getenv('VERCEL_URL')) {
    define('BASE_URL', 'https://' . getenv('VERCEL_URL'));
} else {
    define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/disaster-management');
}

// Create database connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Include PHPMailer if available
if (file_exists(__DIR__.'/mailer.php')) {
    require_once __DIR__.'/mailer.php';
}
?>