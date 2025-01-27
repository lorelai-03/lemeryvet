<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM clinic_info WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $clinic = $result->fetch_assoc();
        
        // Return the result as JSON
        header('Content-Type: application/json');
        echo json_encode($clinic);
    } else {
        echo json_encode(['error' => 'Failed to execute query']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No ID provided']);
}

$conn->close();
?>
