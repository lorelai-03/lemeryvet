<?php
// Database configuration
$host = 'localhost';        // Database host
$dbname = 'u104053626_lemeryvetcare'; // Database name
$user = 'u104053626_lemeryvetcare';         // Database username
$pass = 'Lemeryvet4209*';         // Database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    die('Database connection failed: ' . $e->getMessage());
}
?>
