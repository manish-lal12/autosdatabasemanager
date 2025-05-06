<?php
// Using SQLite instead of MySQL
$database_file = 'autos.sqlite';

try {
    $pdo = new PDO('sqlite:' . $database_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables if they don't exist
    $pdo->exec('CREATE TABLE IF NOT EXISTS autos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        make TEXT,
        year INTEGER,
        mileage INTEGER
    )');
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
