<?php
// Include your database connection file
include('pdo_connection.php'); // Ensure this file includes the PDO setup or database connection

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if 'id' is set in the GET request
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the input
    $id = htmlspecialchars($_GET['id']);

    try {
        // Prepare the SQL DELETE statement
        $sql = "DELETE FROM clinic_info WHERE id = :id";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the ID parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Check if the row was deleted
        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Record deleted successfully';
        } else {
            $response['message'] = 'Record not found or could not be deleted';
        }
    } catch (PDOException $e) {
        // Handle SQL errors
        $response['message'] = 'Error: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'No ID provided';
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
