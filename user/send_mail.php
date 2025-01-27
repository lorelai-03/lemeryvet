<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Create a new PHPMailer instance
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

        // Recipients
        $mail->setFrom('no-reply@example.com', 'Lemery Veterinary Support');  // Set the sender's email and name
        $mail->addAddress('lemeryvets@gmail.com', 'Lemery Veterinary Support');  // Add a recipient

        // Content
        $mail->isHTML(true);                                    // Set email format to HTML
        $mail->Subject = 'New Message from ' . $name;
        $mail->Body    = '<p>Name: ' . htmlspecialchars($name) . '</p>'
                       . '<p>Email: ' . htmlspecialchars($email) . '</p>'
                       . '<p>Message: ' . nl2br(htmlspecialchars($message)) . '</p>';

        // Send the email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
