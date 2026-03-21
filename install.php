<?php

// Quick local setup helper: creates database and tables using sql/mysql.sql
// Only for local dev and trusted environments.

$dsn = 'mysql:host=gateway01.ap-southeast-1.prod.aws.tidbcloud.com;port=4000;dbname=test;charset=utf8mb4';
$user = '2tGN85HQqGriFU6.root';
$pass = 'fWg2s6o5EGjMbmT7';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die('MySQL connection failed: ' . htmlspecialchars($e->getMessage()));
}

$sqlFile = __DIR__ . '/sql/mysql.sql';
if (!file_exists($sqlFile)) {
    die('SQL file not found at ' . htmlspecialchars($sqlFile));
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    die('Could not read SQL file.');
}

try {
    $pdo->exec($sql);
    echo '<h1>Setup complete</h1>';
    echo '<p>Database and tables were created successfully.</p>';
    echo '<p>Remove install.php after running for security.</p>';
} catch (PDOException $e) {
    echo '<h1>Setup failed</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
}

?>
