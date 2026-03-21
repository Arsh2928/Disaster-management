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
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
if (isset($_SERVER['HTTP_HOST'])) {
    if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
        define('BASE_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . '/disaster-management');
    } else {
        define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST']);
    }
} else {
    define('BASE_URL', 'http://localhost/disaster-management');
}

// Create database connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, [
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/ca.pem',
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Include PHPMailer if available
if (file_exists(__DIR__.'/mailer.php')) {
    require_once __DIR__.'/mailer.php';
}
?>