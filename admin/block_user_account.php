<?php
// block_user_account.php

// Database connection details
$host = 'localhost'; // Update as needed
$db = 'u104053626_lemeryvetcare'; // Update as needed
$user = 'u104053626_lemeryvetcare'; // Update as needed
$pass = 'Lemeryvet4209*'; // Update as needed

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the user ID from the query parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

// Prepare the SQL statement
$sql = "UPDATE users SET status = 'inactive' WHERE id = ?";

// Create a prepared statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
    exit;
}

// Bind parameters and execute the statement
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'User account successfully blocked']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No user found with the provided ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to execute SQL statement']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
