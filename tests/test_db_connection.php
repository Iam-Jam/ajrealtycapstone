<?php
$host = '127.0.0.1';
$db   = 'aj_real_estate';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "Connected successfully to the database 'aj_real_estate'.\n";

    // Check if the database exists
    $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'aj_real_estate'");
    if ($stmt->fetch()) {
        echo "The database 'aj_real_estate' exists.\n";
    } else {
        echo "The database 'aj_real_estate' does not exist.\n";
    }
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
