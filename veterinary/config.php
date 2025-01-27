<?php
$servername = "localhost"; // or your server name
$username = "u104053626_lemeryvetcare";        // your MySQL username
$password = "Lemeryvet4209*";            // your MySQL password
$dbname = "u104053626_lemeryvetcare"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
