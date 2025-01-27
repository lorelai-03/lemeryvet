<?php
session_start();
header('Content-Type: application/json');
$response = array();

// Check if the user is logged in based on the session 'id'
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (!$user_id) {
    $response['success'] = false;
    $response['message'] = 'User not logged in.';
    echo json_encode($response);
    exit;
}

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $response['success'] = false;
    $response['message'] = 'Database connection failed: ' . $e->getMessage();
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize the fields to be updated
    $update_fields = array();

    // Collect form data and only add non-empty fields to the update query
    if (!empty($_POST['email'])) {
        $update_fields['email'] = $_POST['email'];
    }

    if (!empty($_POST['full_name'])) {
        $update_fields['full_name'] = $_POST['full_name'];
    }

    if (!empty($_POST['address'])) {
        $update_fields['address'] = $_POST['address'];
    }

    if (!empty($_POST['gender'])) {
        $update_fields['gender'] = $_POST['gender'];
    }

    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $update_fields['password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        } else {
            $response['success'] = false;
            $response['message'] = 'Passwords do not match.';
            echo json_encode($response);
            exit;
        }
    }

    // Handle file upload
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['user_image']['tmp_name'];
        $fileName = $_FILES['user_image']['name'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Check if the file is an image
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = 'uploads/user_images/';
            $dest_file_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_file_path)) {
                // Add the image path to the update fields
                $update_fields['user_image'] = $dest_file_path;

                // Call the function to copy the file to another location
                copyFiles($fileName, $uploadFileDir, ['../admin/uploads/user_images']);
            } else {
                $response['success'] = false;
                $response['message'] = 'There was an error uploading the image.';
                echo json_encode($response);
                exit;
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.';
            echo json_encode($response);
            exit;
        }
    }

    if (!empty($update_fields)) {
        try {
            // Construct the SQL query dynamically based on the fields to be updated
            $set_clause = [];
            $values = [];

            foreach ($update_fields as $field => $value) {
                $set_clause[] = "$field = ?";
                $values[] = $value;
            }

            // Add the user ID to the values array
            $values[] = $user_id;

            // Prepare and execute the update statement
            $stmt = $pdo->prepare('UPDATE users SET ' . implode(', ', $set_clause) . ' WHERE id = ?');
            $stmt->execute($values);

            $response['success'] = true;
            $response['message'] = 'User information updated successfully.';
        } catch (PDOException $e) {
            $response['success'] = false;
            $response['message'] = 'Update failed: ' . $e->getMessage();
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'No valid data to update.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);

// Define source directory and destination directories
function copyFiles($sourceFile, $sourceDir, $destDirs) {
    $sourcePath = $sourceDir . DIRECTORY_SEPARATOR . $sourceFile;

    if (!file_exists($sourcePath)) {
        die("Source file does not exist.");
    }

    foreach ($destDirs as $destDir) {
        // Create destination directory if it does not exist
        $destPath = $destDir . DIRECTORY_SEPARATOR . $sourceFile;
        
        if (!is_dir($destDir)) {
            if (!mkdir($destDir, 0777, true)) {
                die("Failed to create destination directory: $destDir.");
            }
        }

        // Copy the file
        if (!copy($sourcePath, $destPath)) {
            echo "Failed to copy " . $sourceFile . " to $destPath.";
        }
    }
}
?>
