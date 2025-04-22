<?php
require __DIR__.'/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();
require __DIR__.'/config/database.php';

$conn = getDBConnection();
echo "Connected successfully to MySQL ".$conn->server_version;
$conn->close();