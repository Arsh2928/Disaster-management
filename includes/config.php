<?php
session_start();

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'disaster_management');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

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