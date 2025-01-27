<?php
// Database configuration
$host = 'localhost'; // Change if your database is hosted elsewhere
$dbname = 'u104053626_lemeryvetcare';
$username = 'u104053626_lemeryvetcare'; // Change to your database username
$password = 'Lemeryvet4209*'; // Change to your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    echo 'Connection failed: ' . $e->getMessage();
}
?>
