<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..'); 
$dotenv->load();

function getDBConnection() {
    $host = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];
    $name = $_ENV['DB_NAME'];
    $port = $_ENV['DB_PORT'] ?? 3306;

    $conn = new mysqli($host, $user, $pass, $name, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}