<?php
header('Content-Type: application/json');

// Function to send response in JSON format
function sendResponse($success, $message) {
    $response = json_encode(['success' => $success, 'message' => $message]);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $response = json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
    }
    echo $response;
    exit;
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form input
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $new_password = htmlspecialchars(trim($_POST['new_password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    // Check if any required fields are missing
    if (empty($username) || empty($password) || empty($new_password) || empty($confirm_password)) {
        sendResponse(false, 'All fields are required.');
    }

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        sendResponse(false, 'New password and confirm password do not match.');
    }

    // Database connection
    try {
        $host = 'localhost'; // Database host
        $db_name = 'u104053626_lemeryvetcare'; // Database name
        $user = 'u104053626_lemeryvetcare'; // Database username
        $pass = 'Lemeryvet4209*'; // Database password

        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the username exists in the database
        $stmt = $pdo->prepare("SELECT password FROM admin WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing_user) {
            sendResponse(false, 'Username not found.');
        }

        // Verify current password
        if (!password_verify($password, $existing_user['password'])) {
            sendResponse(false, 'Incorrect current password.');
        }

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the admin account with the new username and password
        $update_stmt = $pdo->prepare("UPDATE admin SET username = :username, password = :password WHERE username = :username");
        $update_stmt->bindParam(':username', $username);
        $update_stmt->bindParam(':password', $hashed_password);
        $update_stmt->execute();

        sendResponse(true, 'Admin account updated successfully.');
    } catch (PDOException $e) {
        sendResponse(false, 'Database error: ' . $e->getMessage());
    }
} else {
    sendResponse(false, 'Invalid request method.');
}
