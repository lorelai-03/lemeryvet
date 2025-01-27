<?php 
require_once('db.php');
header('Content-Type: application/json');

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// Start the session
session_start();

// Check if the user is logged in based on the session 'email'
$is_logged_in = isset($_SESSION['email']);

if (!$is_logged_in) {
    echo json_encode(['success' => false, 'message' => 'Error: User not logged in.']);
    $conn->close();
    exit;
}

// Retrieve user session data
$full_name = isset($_SESSION['full_name']) ? $conn->real_escape_string($_SESSION['full_name']) : '';
$email = isset($_SESSION['email']) ? $conn->real_escape_string($_SESSION['email']) : '';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['success' => false, 'message' => 'Error: No data to save.']);
    $conn->close();
    exit;
}

extract($_POST);

// Sanitize input
$full_name = isset($full_name) ? $conn->real_escape_string($full_name) : '';

// Format dates
$start_datetime_formatted = (new DateTime($start_datetime))->format('F j, Y g:i A');
$end_datetime_formatted = (new DateTime($end_datetime))->format('F j, Y g:i A');

// Check if we are inserting or updating
if (empty($id)) {
    // Insert new record
    $sql = "INSERT INTO `schedule_list` (`title`, `description`, `start_datetime`, `end_datetime`, `veterinaryId`, `medicalName`, `full_name`) 
            VALUES ('$title', '$description', '$start_datetime', '$end_datetime', '$veterinaryId', '$medicalName', '$full_name')";
    $action = 'saved';
} else {
    // Update existing record
    $sql = "UPDATE `schedule_list` 
            SET `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', 
                `end_datetime` = '{$end_datetime}', `veterinaryId` = '{$veterinaryId}', `medicalName` = '{$medicalName}', 
                `full_name` = '{$full_name}' 
            WHERE `id` = '{$id}'";
    $action = 'updated';
}

// Execute the query
$save = $conn->query($sql);

if ($save) {
    // Retrieve the veterinarian's email based on veterinaryId
    $vet_query = "SELECT email FROM veterinarians WHERE id = '{$veterinaryId}'";
    $vet_result = $conn->query($vet_query);

    $vet_email = '';
    if ($vet_result && $vet_result->num_rows > 0) {
        $vet_row = $vet_result->fetch_assoc();
        $vet_email = $vet_row['email'];
    }

    // Send emails
    $mail = new PHPMailer(true);

    try {
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

        // Email to user
        $mail->setFrom('no-reply@example.com', 'Lemery Veterinary Support');
        $mail->addAddress($email);                                  // Add the user as a recipient

        // Content for user
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = 'Appointment for ' . htmlspecialchars($medicalName);

        $mail->Body    = 'Dear ' . htmlspecialchars($full_name) . ',<br><br>' .
                         'Thank you for scheduling an appointment with us. We will get back to you shortly.<br><br>' .
                         'Appointment Reminder:<br>' .
                         'Title: ' . htmlspecialchars($title) . '<br>' .
                         'Start: ' . $start_datetime_formatted . '<br>' .
                         'End: ' . $end_datetime_formatted . '<br><br>' .
                         'Best regards,<br>Lemery Veterinary Support';

        $mail->send();

        // Email to veterinarian
        if ($vet_email) {
            $mail->clearAddresses();
            $mail->addAddress($vet_email);                         // Add the veterinarian as a recipient

            // Content for veterinarian
            $mail->Subject = 'New Appointment Scheduled for ' . htmlspecialchars($medicalName);

            $mail->Body    = 'Dear Veterinarian,<br><br>' .
                             'An appointment has been scheduled by ' . htmlspecialchars($full_name) . '.<br><br>' .
                             'Appointment Details:<br>' .
                             'Title: ' . htmlspecialchars($title) . '<br>' .
                             'Start: ' . $start_datetime_formatted . '<br>' .
                             'End: ' . $end_datetime_formatted . '<br><br>' .
                             'Best regards,<br>Lemery Veterinary Support';

            $mail->send();
        }

        echo json_encode(['success' => true, 'action' => $action]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "An Error occurred.\nError: " . $conn->error . "\nSQL: " . $sql]);
}

$conn->close();
?>
