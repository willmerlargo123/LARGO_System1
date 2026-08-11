<?php
// Database connection for the Main System (Hotel System)
$host = getenv('DB_HOST') ?: 'mysql';
$db   = getenv('DB_NAME') ?: 'hotel_system';
$user = getenv('DB_USER') ?: 'hotel_user';
$pass = getenv('DB_PASS') ?: 'hotel_pass';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
