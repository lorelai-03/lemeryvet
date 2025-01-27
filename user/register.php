<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the default timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// Database connection
require 'config.php';

// Initialize response
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $address = htmlspecialchars($_POST['address']);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);
    $phoneNumber = htmlspecialchars($_POST['phoneNumber']);

    try {
        // Check if email already exists
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $response['message'] = 'Email already registered.';
            echo json_encode($response);
            exit;
        }

        // Insert user into database
        $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password, address, dob, gender, phone_number, verified) VALUES (?, ?, ?, ?, ?, ?, ?, 0)');
        if ($stmt->execute([$fullName, $email, $password, $address, $dob, $gender, $phoneNumber])) {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Calculate OTP expiry time
            $now = new DateTime(); // Current time in Asia/Manila
            $otpExpiry = clone $now; // Clone current time to avoid modification
            $otpExpiry->add(new DateInterval('PT10M')); // Add 10 minutes
            $otpExpiryFormatted = $otpExpiry->format('Y-m-d H:i:s'); // Format as string

            // Store OTP in the database
            $stmt = $pdo->prepare('INSERT INTO email_verifications (email, otp, expiry) VALUES (?, ?, ?)');
            $stmt->execute([$email, $otp, $otpExpiryFormatted]);

            // Create a PHPMailer instance
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lemeryvets@gmail.com'; // Your Gmail address
            $mail->Password   = 'rrwmnrjrmngckrgy'; // Use an App Password if you have 2-Step Verification enabled
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
            $mail->Port       = 587; // Port for TLS

            // Configure SMTP options to skip SSL verification (for debugging)
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom('no-reply@example.com', 'Lemery Veterinary Support');
            $mail->addAddress($email);

            // Prepare email content
            $expiryNote = 'Note: This OTP code is valid for only 10 minutes from the time of generation.';
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = 'Your OTP code is: <b>' . $otp . '</b><br><br>' . $expiryNote;
            $mail->AltBody = 'Your OTP code is: ' . $otp . "\n\n" . $expiryNote;

            // Send the email
            $mail->send();
            $response['success'] = true;
            $response['message'] = 'Registration successful. Please check your email for the OTP.';
        } else {
            $response['message'] = 'Registration failed. Please try again.';
        }
    } catch (Exception $e) {
        $response['message'] = 'An error occurred: ' . $e->getMessage();
    }

    // Ensure no extra output
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response['message'] = 'Invalid request method.';
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
