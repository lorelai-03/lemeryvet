<?php
// Database connection details
$host = 'localhost';
$db = 'u104053626_lemeryvetcare';
$user = 'u104053626_lemeryvetcare';
$pass = 'Lemeryvet4209*';

// Define source directory and destination directories
$sourceDir = 'uploads';
$destDirs = [
    '../user/uploads',
];

// Function to handle file copying
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
            die("Failed to copy " . $sourceFile . " to $destPath.");
        }
    }
}

// Initialize response
$response = ['status' => 'error', 'message' => 'Something went wrong. Please try again.'];

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Could not connect to the database: ' . $e->getMessage()]));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $business_permit_no = $_POST['business_permit_no'];
    $clinic_name = $_POST['clinic_name'];
    $address = $_POST['address'];
    $line_of_business = $_POST['line_of_business'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Handle file upload
    $clinic_image = '';
    if (isset($_FILES['clinic_image']) && $_FILES['clinic_image']['error'] === 0) {
        $image_dir = $sourceDir; // Upload directory
        $original_filename = pathinfo($_FILES['clinic_image']['name'], PATHINFO_FILENAME); // Original filename
        $extension = pathinfo($_FILES['clinic_image']['name'], PATHINFO_EXTENSION); // File extension
        $image_name = uniqid($original_filename . '_', true) . '.' . $extension; // Unique filename
        $image_path = $image_dir . DIRECTORY_SEPARATOR . $image_name;

        // Move uploaded file to the source directory
        if (move_uploaded_file($_FILES['clinic_image']['tmp_name'], $image_path)) {
            // Copy the file to additional directories
            copyFiles($image_name, $sourceDir, $destDirs);
        } else {
            $response['message'] = 'Failed to upload clinic image.';
            echo json_encode($response);
            exit;
        }
    } else {
        $response['message'] = 'Clinic image is required.';
        echo json_encode($response);
        exit;
    }

    // Insert into the database
    $sql = "INSERT INTO clinic_info (business_permit_no, clinic_name, address, line_of_business, clinic_image, latitude, longitude) 
            VALUES (:business_permit_no, :clinic_name, :address, :line_of_business, :clinic_image, :latitude, :longitude)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':business_permit_no' => $business_permit_no,
        ':clinic_name' => $clinic_name,
        ':address' => $address,
        ':line_of_business' => $line_of_business,
        ':clinic_image' => $image_dir . '/' . $image_name, // Save the image path relative to the source directory
        ':latitude' => $latitude,
        ':longitude' => $longitude
    ]);

    if ($stmt) {
        $response = ['status' => 'success', 'message' => 'Clinic information added successfully!'];
    }
}

// Return the response
echo json_encode($response);
?>
