<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

// Define source directory and destination directories
$sourceDir = 'uploads/pet_products';
$destDirs = [
    '../user/uploads/pet_products',
    '../admin/uploads/pet_products'
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

// Get the POST data
$id = $_POST['id'];
$pet_name = $_POST['pet_name'];
$pet_description = $_POST['pet_description'];
$pet_price = $_POST['pet_price'];

// Handle file upload if a new file was selected
if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] === UPLOAD_ERR_OK) {
    $imagePath = $sourceDir . '/' . $_FILES['pet_image']['name'];
    
    // Move the uploaded file to the source directory
    if (move_uploaded_file($_FILES['pet_image']['tmp_name'], $imagePath)) {
        // Copy the file to multiple directories
        $sourceFile = basename($_FILES['pet_image']['name']);
        copyFiles($sourceFile, $sourceDir, $destDirs);
    } else {
        echo 'Failed to upload the image.';
        exit();
    }
} else {
    // If no new file was selected, keep the existing image path
    $query = $pdo->prepare('SELECT pet_image FROM pet_products WHERE id = :id');
    $query->execute(['id' => $id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $imagePath = $result['pet_image'];
}

// Update the product in the database
$query = $pdo->prepare('UPDATE pet_products SET pet_name = :name, pet_description = :description, pet_price = :price, pet_image = :image WHERE id = :id');
$result = $query->execute([
    'name' => $pet_name,
    'description' => $pet_description,
    'price' => $pet_price,
    'image' => $imagePath,
    'id' => $id
]);

// Reset the original_price column to NULL
$resetQuery = $pdo->prepare('UPDATE pet_products SET original_price = NULL WHERE id = :id');
$resetQuery->execute(['id' => $id]);

if ($result) {
    echo 'success';
} else {
    echo 'error';
}
?>
