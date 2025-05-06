<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if not exists (optional for prod)
    $pdo->exec('CREATE TABLE IF NOT EXISTS autos (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        make TEXT,
        year INTEGER,
        mileage INTEGER
    )');
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>