<?php

// Quick local setup helper: creates database and tables using sql/mysql.sql
// Only for local dev and trusted environments.

$dsn = 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';charset=utf8mb4';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

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
