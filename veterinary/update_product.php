<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

// Get the POST data
$id = $_POST['id'];
$medical_name = $_POST['medical_name'];
$medical_description = $_POST['medical_description'];
$medical_price = $_POST['medical_price'];

// Define source directory and destination directories for file copy
$sourceDir = 'uploads/medical_product';
$destDirs = [
    '../user/uploads/medical_product',
    '../admin/uploads/medical_product'
];

// Handle file upload if a new file was selected
if (isset($_FILES['medical_image']) && $_FILES['medical_image']['error'] === UPLOAD_ERR_OK) {
    $imagePath = 'uploads/medical_product/' . $_FILES['medical_image']['name'];
    
    // Move uploaded file to the source directory
    move_uploaded_file($_FILES['medical_image']['tmp_name'], $imagePath);
    
    // Call the function to copy the file to multiple directories
    copyFiles($_FILES['medical_image']['name'], $sourceDir, $destDirs);
} else {
    // If no new file was selected, keep the existing image path
    $query = $pdo->prepare('SELECT medical_image FROM medical_products WHERE id = :id');
    $query->execute(['id' => $id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $imagePath = $result['medical_image'];
}

// Update the product in the database
$query = $pdo->prepare('UPDATE medical_products SET medical_name = :name, medical_description = :description, medical_price = :price, medical_image = :image WHERE id = :id');
$result = $query->execute([
    'name' => $medical_name,
    'description' => $medical_description,
    'price' => $medical_price,
    'image' => $imagePath,
    'id' => $id
]);

// Reset the original_price column to NULL
$resetQuery = $pdo->prepare('UPDATE medical_products SET original_price = NULL WHERE id = :id');
$resetQuery->execute(['id' => $id]);

if ($result) {
    echo 'success';
} else {
    echo 'error';
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
