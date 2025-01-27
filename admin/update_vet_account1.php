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

// Validate and process the form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = htmlspecialchars($_POST['id']);
    $fullname = isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : null;
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
    $new_password = isset($_POST['new_password']) ? htmlspecialchars($_POST['new_password']) : null;
    $confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : null;
    $stats = isset($_POST['stats']) ? htmlspecialchars($_POST['stats']) : null;

    // Initialize vet image
    $vet_image = null;

    // Handle file upload for vet image
    if (!empty($_FILES['vet_image']['name'])) {
        $original_filename = pathinfo($_FILES['vet_image']['name'], PATHINFO_FILENAME); // Get original filename without extension
        $extension = pathinfo($_FILES['vet_image']['name'], PATHINFO_EXTENSION); // Get file extension

        // Create a unique name with a timestamp and the original filename
        $image_name = time() . '_' . $original_filename . '.' . $extension;

        $source_path = 'C:/xampp/htdocs/lemeryvet/admin/uploads/vet_images/' . $image_name; // Absolute path to the source directory
        $target_path = 'C:/xampp/htdocs/lemeryvet/veterinary/uploads/vet_images/' . $image_name; // Absolute path to the target directory

        // Move uploaded file to the source directory
        if (move_uploaded_file($_FILES['vet_image']['tmp_name'], $source_path)) {
            // Copy the file to the target directory
            if (copy($source_path, $target_path)) {
                // Save the path relative to the target directory for the database
                $vet_image = 'uploads/vet_images/' . $image_name;
            } else {
                sendResponse(false, 'Failed to copy vet image to the target directory.');
            }
        } else {
            sendResponse(false, 'Failed to upload vet image.');
        }
    }

    // Database connection
    try {
        $host = 'localhost'; // Change to your database host
        $db_name = 'db_veterinary_clinic'; // Change to your database name
        $user = 'root'; // Change to your database username
        $pass = ''; // Change to your database password

        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query dynamically
        $updates = [];
        $params = [':id' => $id];

        if (!empty($fullname)) {
            $updates[] = 'fullname = :fullname';
            $params[':fullname'] = $fullname;
        }
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                // Only update password if new and confirm passwords match
                $updates[] = 'password = :password';
                $params[':password'] = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password
            } else {
                sendResponse(false, 'Passwords do not match.');
            }
        }
        if (!empty($stats)) {
            $updates[] = 'stats = :stats';
            $params[':stats'] = $stats;
        }
        if ($vet_image !== null) {
            $updates[] = 'vet_image = :vet_image';
            $params[':vet_image'] = $vet_image;
        }

        if (empty($updates)) {
            sendResponse(false, 'No fields to update.');
        }

        $sql = "UPDATE veterinarians SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        sendResponse(true, 'Veterinarian information updated successfully.');
    } catch (PDOException $e) {
        sendResponse(false, 'Database error: ' . $e->getMessage());
    }
}
?>
