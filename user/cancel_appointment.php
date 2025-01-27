<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

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
            // Prepare PHPMailer
            $mail = new PHPMailer(true);
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'lemeryvets@gmail.com';                 // SMTP username
            $mail->Password   = 'rrwmnrjrmngckrgy';                      // SMTP password (use an App Password if 2-Step Verification is enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
            $mail->Port       = 587;                                    // TCP port to connect to

            // Skip SSL verification for debugging
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Retrieve the veterinarian's email based on veterinaryId
            $veterinaryId = $appointment['veterinaryId'];
            $vet_query = "SELECT email FROM veterinarians WHERE id = ?";
            $stmt = $pdo->prepare($vet_query);
            $stmt->execute([$veterinaryId]);
            $vet_result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($vet_result) {
                $vet_email = $vet_result['email'];

                // Set email details
                $mail->setFrom('no-reply@example.com', 'Lemery Veterinary Support');
                $mail->addAddress($vet_email); // Add the veterinarian as a recipient

                // Content for veterinarian
                $mail->Subject = 'Appointment Cancellation Notice';
                $mail->isHTML(true); // Set email format to HTML

                $mail->Body    = 'Dear Veterinarian,<br><br>' .
                                 'The appointment for ' . htmlspecialchars($appointment['full_name']) . ' has been canceled.<br><br>' .
                                 'Appointment Details:<br>' .
                                 'Title: ' . htmlspecialchars($appointment['title']) . '<br>' .
                                 'Start: ' . htmlspecialchars($appointment['start_datetime']) . '<br>' .
                                 'End: ' . htmlspecialchars($appointment['end_datetime']) . '<br><br>' .
                                 'Reason: Appointment canceled by user.<br><br>' .
                                 'Best regards,<br>Lemery Veterinary Support';

                // Send email
                $mail->send();
            }

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
