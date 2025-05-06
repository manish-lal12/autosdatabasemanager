<?php
$dbUrl = getenv('DATABASE_URL');

if (!$dbUrl) {
    die("DATABASE_URL environment variable not set.");
}

try {
    // Parse the URL
    $url = parse_url($dbUrl);
    parse_str($url['query'] ?? '', $query); // Parse ?sslmode=require

    $host = $url['host'];
    $port = $url['port'] ?? 5432;
    $user = $url['user'];
    $pass = $url['pass'];
    $db   = ltrim($url['path'], '/'); // Remove leading slash
    $sslmode = $query['sslmode'] ?? 'require';

    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=$sslmode";

    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if not exists
    $pdo->exec('CREATE TABLE IF NOT EXISTS autos (
        id SERIAL PRIMARY KEY,
        make TEXT,
        year INTEGER,
        mileage INTEGER
    )');

    echo "Connected and table checked successfully.";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>