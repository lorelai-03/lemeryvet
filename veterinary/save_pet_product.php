<?php
session_start(); // Start the session to access user ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'u104053626_lemeryvetcare', 'Lemeryvet4209*', 'u104053626_lemeryvetcare');

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Get form inputs
    $pet_name = $_POST['pet_name'];
    $pet_description = $_POST['pet_description'];
    $pet_price = $_POST['pet_price'];

    // Get user ID from session (assuming it's stored in session)
    if (isset($_SESSION['id'])) {
        $veterinary_id = $_SESSION['id'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit();
    }

    // Define the target directory for saving the image
    $target_dir = "uploads/pet_products/";

    // Create the directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory with appropriate permissions
    }

    // Handle file upload
    if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] == 0) {
        $target_file = $target_dir . basename($_FILES["pet_image"]["name"]);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["pet_image"]["tmp_name"], $target_file)) {
            // Insert form data into the database
            $stmt = $conn->prepare("INSERT INTO pet_products (pet_name, pet_description, pet_price, pet_image, veterinary_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsi", $pet_name, $pet_description, $pet_price, $target_file, $veterinary_id);

            if ($stmt->execute()) {
                // Define source directory and destination directories
                $sourceFile = basename($_FILES["pet_image"]["name"]);
                $sourceDir = 'uploads/pet_products';
                $destDirs = [
                    '../user/uploads/pet_products',  // Outside the base uploads directory
                    '../admin/uploads/pet_products' // Outside the base uploads directory
                ];

                // Copy the file to multiple directories
                copyFiles($sourceFile, $sourceDir, $destDirs);

                echo json_encode(['status' => 'success', 'message' => 'Pet product saved successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save pet product in the database']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or there was an error during upload']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

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
            echo "Failed to copy " . $sourceFile . " to $destPath.";
        }
    }
}
?>
