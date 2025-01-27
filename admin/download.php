<?php
// Include database configuration
include 'pdo_connection.php';

// Check if the file parameter is set
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Sanitize the filename to prevent path traversal attacks
    $file = basename($file);

    // Define the path to the files
    // Update this path to match the new directory structure
    $filePath = 'C:/xampp/htdocs/lemeryvet/veterinary/uploads/' . $file;

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to force download the file
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); // Adjust content type if needed
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Read the file and output it to the browser
        readfile($filePath);
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'No file specified.';
}
?>
