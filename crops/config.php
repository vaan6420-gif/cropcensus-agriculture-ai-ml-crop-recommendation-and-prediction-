<?php
declare(strict_types=1);

session_start();

$databaseHost = getenv('CROP_DB_HOST') ?: '127.0.0.1';
$databaseName = getenv('CROP_DB_NAME') ?: 'crop_census';
$databaseUser = getenv('CROP_DB_USER') ?: 'root';
$databasePassword = getenv('CROP_DB_PASSWORD') ?: '';

try {
    $serverPdo = new PDO(
        'mysql:host=' . $databaseHost . ';charset=utf8mb4',
        $databaseUser,
        $databasePassword,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    $serverPdo->exec(
        'CREATE DATABASE IF NOT EXISTS `' . str_replace('`', '``', $databaseName) .
        '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
    );

    $pdo = new PDO(
        'mysql:host=' . $databaseHost . ';dbname=' . $databaseName . ';charset=utf8mb4',
        $databaseUser,
        $databasePassword,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        )
    );
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY users_email_unique (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
} catch (PDOException $exception) {
    http_response_code(500);
    exit('Database connection failed. Check your MySQL settings.');
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function safePostLoginDestination(?string $destination): string
{
    $allowedDestinations = array(
        'index.php',
        'crop_recommendation.php',
        'fertilizer_recommendation.php',
        'crop_prediction.php',
        'yield_prediction.php',
        'rainfall_prediction.php'
    );

    return in_array($destination, $allowedDestinations, true) ? $destination : 'index.php';
}

function requireFeatureLogin(): void
{
    if (!isLoggedIn()) {
        $destination = safePostLoginDestination(basename($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
        $_SESSION['flash'] = 'Please sign in to use the farm tools.';
        header('Location: login.php?redirect=' . rawurlencode($destination));
        exit;
    }
}
