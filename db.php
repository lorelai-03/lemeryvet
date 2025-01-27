<?php
// Database connection details
$host = 'localhost'; // Replace with your database host
$dbname = 'db_veterinary_clinic'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Create a new mysqli connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8
$conn->set_charset("utf8");
?>
