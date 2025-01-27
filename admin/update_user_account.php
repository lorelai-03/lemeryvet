<?php
header('Content-Type: application/json');

// Define source directory and destination directories
$sourceDir = 'uploads/user_images';
$destDirs = [
    '../user/uploads/user_images',
];

// Function to handle file copying
function copyFiles($sourceFile, $sourceDir, $destDirs) {
    $sourcePath = $sourceDir . DIRECTORY_SEPARATOR . $sourceFile;

    if (!file_exists($sourcePath)) {
        sendResponse(false, "Source file does not exist.");
    }

    foreach ($destDirs as $destDir) {
        $destPath = $destDir . DIRECTORY_SEPARATOR . $sourceFile;

        if (!is_dir($destDir)) {
            if (!mkdir($destDir, 0777, true)) {
                sendResponse(false, "Failed to create destination directory: $destDir.");
            }
        }

        if (!copy($sourcePath, $destPath)) {
            sendResponse(false, "Failed to copy $sourceFile to $destPath.");
        }
    }
}

// Function to send response in JSON format
function sendResponse($success, $message) {
    $response = json_encode(['success' => $success, 'message' => $message]);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $response = json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
    }
    echo $response;
    exit;
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $id = htmlspecialchars($_POST['id']);
    $full_name = isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : null;
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
    $new_password = isset($_POST['new_password']) ? htmlspecialchars($_POST['new_password']) : null;
    $confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : null;
    $status = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : null;

    $user_image = null;

    // Handle file upload for user image
    if (!empty($_FILES['user_image']['name'])) {
        $original_filename = pathinfo($_FILES['user_image']['name'], PATHINFO_FILENAME);
        $extension = pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '_' . $original_filename . '.' . $extension;
        $image_path = $sourceDir . DIRECTORY_SEPARATOR . $image_name;

        if (move_uploaded_file($_FILES['user_image']['tmp_name'], $image_path)) {
            // Copy the uploaded file to additional directories
            copyFiles($image_name, $sourceDir, $destDirs);

            // Save the relative path to the image
            $user_image = $sourceDir . '/' . $image_name;
        } else {
            sendResponse(false, 'Failed to upload user image.');
        }
    }

    // Database connection
    try {
        $host = 'localhost';
        $db_name = 'u104053626_lemeryvetcare';
        $user = 'u104053626_lemeryvetcare';
        $pass = 'Lemeryvet4209*';

        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare dynamic SQL query
        $updates = [];
        $params = [':id' => $id];

        if (!empty($full_name)) {
            $updates[] = 'full_name = :full_name';
            $params[':full_name'] = $full_name;
        }
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                $updates[] = 'password = :password';
                $params[':password'] = password_hash($new_password, PASSWORD_DEFAULT);
            } else {
                sendResponse(false, 'Passwords do not match.');
            }
        }
        if (!empty($status)) {
            $updates[] = 'status = :status';
            $params[':status'] = $status;
        }
        if ($user_image !== null) {
            $updates[] = 'user_image = :user_image';
            $params[':user_image'] = $user_image;
        }

        if (empty($updates)) {
            sendResponse(false, 'No fields to update.');
        }

        $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        sendResponse(true, 'User information updated successfully.');
    } catch (PDOException $e) {
        sendResponse(false, 'Database error: ' . $e->getMessage());
    }
} else {
    sendResponse(false, 'Invalid request method.');
}
?>
