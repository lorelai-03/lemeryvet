<?php
// Define source directory and destination directories
$sourceDir = 'uploads/veterinary_services';
$destDirs = [
    '../user/uploads/veterinary_services',
    '../admin/uploads/veterinary_services'
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
            echo "Failed to copy " . $sourceFile . " to $destPath.";
        }
    }
}

// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

// Get the POST data
$id = $_POST['id'];
$veterinary_name = $_POST['veterinary_name'];
$veterinary_description = $_POST['veterinary_description'];
$veterinary_price = $_POST['veterinary_price'];

// Handle file upload if a new file was selected
if (isset($_FILES['veterinary_image']) && $_FILES['veterinary_image']['error'] === UPLOAD_ERR_OK) {
    $imageFileName = $_FILES['veterinary_image']['name'];
    $imagePath = $sourceDir . DIRECTORY_SEPARATOR . $imageFileName;

    // Move uploaded file to the source directory
    if (move_uploaded_file($_FILES['veterinary_image']['tmp_name'], $imagePath)) {
        // Copy the file to additional directories
        copyFiles($imageFileName, $sourceDir, $destDirs);
    } else {
        die("Failed to upload image.");
    }
} else {
    // If no new file was selected, keep the existing image path
    $query = $pdo->prepare('SELECT veterinary_image FROM veterinary_services WHERE id = :id');
    $query->execute(['id' => $id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $imagePath = $result['veterinary_image'];
}

// Update the service in the database
$query = $pdo->prepare('UPDATE veterinary_services SET veterinary_name = :name, veterinary_description = :description, veterinary_price = :price, veterinary_image = :image WHERE id = :id');
$result = $query->execute([
    'name' => $veterinary_name,
    'description' => $veterinary_description,
    'price' => $veterinary_price,
    'image' => $imagePath,
    'id' => $id
]);

// Reset the original_price column to NULL
$resetQuery = $pdo->prepare('UPDATE veterinary_services SET original_price = NULL WHERE id = :id');
$resetQuery->execute(['id' => $id]);

if ($result) {
    echo 'success';
} else {
    echo 'error';
}
?>
