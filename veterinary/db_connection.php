<?php
// db_connection.php

$host = 'localhost'; // or your database host
$dbname = 'u104053626_lemeryvetcare'; // your database name
$username = 'u104053626_lemeryvetcare'; // your database username
$password = 'Lemeryvet4209*'; // your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
