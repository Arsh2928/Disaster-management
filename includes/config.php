<?php
// Removed duplicate session_start
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
    
    // Custom Session Handler for Vercel Serverless
    class DatabaseSessionHandler implements SessionHandlerInterface {
        private $pdo;
        public function __construct($pdo) { $this->pdo = $pdo; }
        public function open(string $path, string $name): bool { return true; }
        public function close(): bool { return true; }
        public function read(string $id): string|false {
            $stmt = $this->pdo->prepare("SELECT data FROM sessions WHERE id = ?");
            $stmt->execute([$id]);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) return $row['data'];
            return '';
        }
        public function write(string $id, string $data): bool {
            $stmt = $this->pdo->prepare("REPLACE INTO sessions (id, data, last_accessed) VALUES (?, ?, CURRENT_TIMESTAMP)");
            return $stmt->execute([$id, $data]);
        }
        public function destroy(string $id): bool {
            $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE id = ?");
            return $stmt->execute([$id]);
        }
        public function gc(int $max_lifetime): int|false {
            $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE last_accessed < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL ? SECOND)");
            $stmt->execute([$max_lifetime]);
            return $stmt->rowCount();
        }
    }
    
    session_set_save_handler(new DatabaseSessionHandler($pdo), true);
    session_start();
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Include PHPMailer if available
if (file_exists(__DIR__.'/mailer.php')) {
    require_once __DIR__.'/mailer.php';
}
?>