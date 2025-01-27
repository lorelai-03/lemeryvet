<?php
header('Content-Type: application/json');

// Define source directory and destination directories
$sourceDir = 'uploads';
$destDirs = [
    '../user/uploads',
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
    $business_permit_no = isset($_POST['business_permit_no']) ? htmlspecialchars($_POST['business_permit_no']) : null;
    $clinic_name = isset($_POST['clinic_name']) ? htmlspecialchars($_POST['clinic_name']) : null;
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : null;
    $line_of_business = isset($_POST['line_of_business']) ? htmlspecialchars($_POST['line_of_business']) : null;
    $latitude = isset($_POST['latitude']) ? htmlspecialchars($_POST['latitude']) : null;
    $longitude = isset($_POST['longitude']) ? htmlspecialchars($_POST['longitude']) : null;

    $clinic_image = '';

    // Handle file upload
    if (!empty($_FILES['clinic_image']['name'])) {
        $original_filename = pathinfo($_FILES['clinic_image']['name'], PATHINFO_FILENAME);
        $extension = pathinfo($_FILES['clinic_image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '_' . $original_filename . '.' . $extension;
        $image_path = $sourceDir . DIRECTORY_SEPARATOR . $image_name;

        if (move_uploaded_file($_FILES['clinic_image']['tmp_name'], $image_path)) {
            // Copy file to destination directories
            copyFiles($image_name, $sourceDir, $destDirs);
            $clinic_image = $image_path;
        } else {
            sendResponse(false, 'Failed to upload and process clinic image.');
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

        // Build update query dynamically
        $updates = [];
        $params = [':id' => $id];

        if (!empty($business_permit_no)) {
            $updates[] = 'business_permit_no = :business_permit_no';
            $params[':business_permit_no'] = $business_permit_no;
        }
        if (!empty($clinic_name)) {
            $updates[] = 'clinic_name = :clinic_name';
            $params[':clinic_name'] = $clinic_name;
        }
        if (!empty($address)) {
            $updates[] = 'address = :address';
            $params[':address'] = $address;
        }
        if (!empty($line_of_business)) {
            $updates[] = 'line_of_business = :line_of_business';
            $params[':line_of_business'] = $line_of_business;
        }
        if (!empty($latitude)) {
            $updates[] = 'latitude = :latitude';
            $params[':latitude'] = $latitude;
        }
        if (!empty($longitude)) {
            $updates[] = 'longitude = :longitude';
            $params[':longitude'] = $longitude;
        }
        if (!empty($clinic_image)) {
            $updates[] = 'clinic_image = :clinic_image';
            $params[':clinic_image'] = $clinic_image;
        }

        if (empty($updates)) {
            sendResponse(false, 'No fields to update.');
        }

        $sql = "UPDATE clinic_info SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        sendResponse(true, 'Clinic information updated successfully.');
    } catch (PDOException $e) {
        sendResponse(false, 'Database error: ' . $e->getMessage());
    }
} else {
    sendResponse(false, 'Invalid request method.');
}
?>
