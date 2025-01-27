<?php
session_start();
include 'db_connection.php'; // Include your database connection file

$response = array('success' => false, 'message' => 'Unknown error');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        $response['message'] = 'User not logged in';
        echo json_encode($response);
        exit();
    }

    // Get the user's email from the session
    $email = $_SESSION['email'];

    // Fetch current password, vet_image, and other details from the database
    $stmt = $pdo->prepare("SELECT password, vet_image, clinic_name FROM veterinarians WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $response['message'] = 'User not found';
        echo json_encode($response);
        exit();
    }

    // Initialize variables for updates
    $updatePassword = false;
    $updateImage = false;
    $updateClinicName = false;
    $currentPassword = $_POST['password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $clinicName = $_POST['clinic_name'] ?? '';
    $imagePath = $user['vet_image']; // Default to existing image

    // Handle password update
    if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
        if (!password_verify($currentPassword, $user['password'])) {
            $response['message'] = 'Current password is incorrect';
            echo json_encode($response);
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $response['message'] = 'New passwords do not match';
            echo json_encode($response);
            exit();
        }

        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $updatePassword = true;
    }

    // Handle clinic name update
    if (!empty($clinicName) && $clinicName !== $user['clinic_name']) {
        $updateClinicName = true;
    }

    // Handle file upload and copying the file to multiple destinations
    if (isset($_FILES['vet_image']) && $_FILES['vet_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/vet_images/';
        $uploadFile = $uploadDir . basename($_FILES['vet_image']['name']);
        
        if (move_uploaded_file($_FILES['vet_image']['tmp_name'], $uploadFile)) {
            $imagePath = 'uploads/vet_images/' . basename($_FILES['vet_image']['name']); // Save path for database
            $updateImage = true;

            // Copy the image to other directories
            $destDirs = ['../user/uploads/vet_images'];
            copyFiles(basename($_FILES['vet_image']['name']), $uploadDir, $destDirs);

        } else {
            $response['message'] = 'File upload failed';
            echo json_encode($response);
            exit();
        }
    }

    // Prepare the update query
    $updateFields = [];
    $params = [];

    if ($updatePassword) {
        $updateFields[] = 'password = ?';
        $params[] = $hashedNewPassword;
    }

    if ($updateImage) {
        $updateFields[] = 'vet_image = ?';
        $params[] = $imagePath;
    }

    if ($updateClinicName) {
        $updateFields[] = 'clinic_name = ?';
        $params[] = $clinicName;
    }

    // Add email parameter for the WHERE clause
    $updateFields = implode(', ', $updateFields);
    $params[] = $email;

    if (!empty($updateFields)) {
        $stmt = $pdo->prepare("UPDATE veterinarians SET $updateFields WHERE email = ?");
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Veterinary account updated successfully';
        } else {
            $response['message'] = 'No changes were made';
        }
    } else {
        $response['message'] = 'No valid fields to update';
    }

    echo json_encode($response);
}

// Function to handle file copying to multiple directories
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
