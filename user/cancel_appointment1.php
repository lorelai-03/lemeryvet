<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=db_veterinary_clinic', 'root', '');

// Ensure appointment_id is set and valid
if (isset($_POST['appointment_id']) && is_numeric($_POST['appointment_id'])) {
    $appointmentId = intval($_POST['appointment_id']);

    // Start a transaction
    $pdo->beginTransaction();

    try {
        // Fetch the appointment details
        $stmt = $pdo->prepare("SELECT * FROM schedule_list WHERE id = ?");
        $stmt->execute([$appointmentId]);
        $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($appointment) {
            // Debugging: Output fetched appointment data
            error_log("Fetched appointment: " . print_r($appointment, true));

            // Insert into the canceled_appointments table
            $stmt = $pdo->prepare(
                "INSERT INTO canceled_appointments (original_appointment_id, patient_name, appointment_date, reason) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([
                $appointment['id'], 
                $appointment['full_name'], // Use full_name as patient_name
                $appointment['start_datetime'] . ' to ' . $appointment['end_datetime'], // Combine start_datetime and end_datetime as appointment_date
                'Appointment canceled by user'
            ]);

            // Delete from the original appointments table
            $stmt = $pdo->prepare("DELETE FROM schedule_list WHERE id = ?");
            $stmt->execute([$appointmentId]);

            // Commit the transaction
            $pdo->commit();

            echo "Appointment canceled successfully.";
        } else {
            echo "Appointment not found.";
        }
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $pdo->rollBack();
        echo "Failed to cancel the appointment: " . $e->getMessage();
    }
} else {
    echo "Invalid appointment ID.";
}
?>
