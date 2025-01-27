<?php
session_start();
require_once 'db.php'; // Ensure this file establishes the database connection as $conn

// Check if user is logged in and the required parameters are passed
if (isset($_SESSION['email']) && isset($_POST['scheduleId']) && isset($_POST['status'])) {
    $scheduleId = $_POST['scheduleId'];
    $status = $_POST['status'];

    // Prepare the update query
    $sql = "UPDATE `schedule_list` SET `status` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind the parameters and execute
    if (!$stmt->bind_param("si", $status, $scheduleId)) {
        die('Bind param failed: ' . $stmt->error);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Return a success response with the updated status
        echo json_encode(['success' => true, 'id' => $scheduleId, 'status' => $status]);
    } else {
        // Return an error response
        echo json_encode(['success' => false]);
    }

    // Close the statement
    $stmt->close();
} else {
    // If parameters are missing, return an error response
    echo json_encode(['success' => false]);
}

// Close the database connection
$conn->close();
?>
