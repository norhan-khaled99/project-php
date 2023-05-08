<?php
$host = 'localhost';
$username = 'phpuser';
$password = 'Iti123456';
$dbname = 'cafeteria_db';

try {
    $pdo = new PDO("mysql:host=$host;", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $pdo->exec($sql);

    echo "Database created successfully";
} catch(PDOException $e) {
    echo "Error creating database: " . $e->getMessage();
}

?>