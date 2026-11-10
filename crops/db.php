<?php
declare(strict_types=1);

/*
 * XAMPP defaults are used here. Set DB_HOST, DB_NAME, DB_USER and DB_PASS
 * as environment variables when deploying with different credentials.
 */
$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbName = getenv('DB_NAME') ?: 'crops';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';

if (!preg_match('/^[A-Za-z0-9_]+$/', $dbName)) {
    http_response_code(500);
    exit('Invalid database configuration.');
}

try {
    $server = new PDO(
        "mysql:host={$dbHost};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    $server->exec(
        "CREATE DATABASE IF NOT EXISTS `{$dbName}` "
        . "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
    );

    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(20) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB"
    );
    $columns = $pdo->query("SHOW COLUMNS FROM users LIKE 'phone'")->fetch();
    if (!$columns) {
        $pdo->exec("ALTER TABLE users ADD phone VARCHAR(20) NULL AFTER email");
        $pdo->exec("ALTER TABLE users ADD UNIQUE KEY users_phone_unique (phone)");
    }
} catch (PDOException $exception) {
    http_response_code(500);
    exit('Database connection failed. Start MySQL in XAMPP and try again.');
}
