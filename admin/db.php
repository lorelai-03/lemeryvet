<?php
// Database connection details
$host = 'localhost'; // Replace with your database host
$dbname = 'u104053626_lemeryvetcare'; // Replace with your database name
$username = 'u104053626_lemeryvetcare'; // Replace with your database username
$password = 'Lemeryvet4209*'; // Replace with your database password

// Create a new mysqli connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8
$conn->set_charset("utf8");
?>
