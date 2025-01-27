<?php
// db.php - Ensure your database connection is included
require_once 'db.php';

if (isset($_GET['id'])) {
    $scheduleId = $_GET['id'];

    // Prepare the SQL query to delete the schedule item
    $sql = "DELETE FROM schedule_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error in query preparation');
    }

    // Bind the parameter and execute the query
    $stmt->bind_param('i', $scheduleId);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        // Redirect to the page with a success message or show a success alert
        header("Location: veterinary_appointment_schedule.php?message=deleted");
        exit();
    } else {
        // Handle the case where no rows were affected (e.g., invalid ID)
        echo "Failed to delete the record.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
