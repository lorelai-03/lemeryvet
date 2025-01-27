<?php
// Database connection
require 'config.php';

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Your Semaphore API key
$semaphoreApiKey = '32ac987bd908044bb319318827a8a1e0';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'];

    // Validate OTP from the email verification
    $stmt = $pdo->prepare('SELECT * FROM email_verifications WHERE otp = ? AND expiry > NOW()');
    $stmt->execute([$otp]);
    if ($stmt->rowCount() > 0) {
        $verification = $stmt->fetch();
        $email = $verification['email'];

        // Get phone number associated with the email
        $stmt = $pdo->prepare('SELECT phone_number FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        $phoneNumber = $user['phone_number'];

        // Update user status to verified for email
        $stmt = $pdo->prepare('UPDATE users SET verified = 1 WHERE email = ?');
        if ($stmt->execute([$email])) {
            // Email OTP successfully verified, proceed to generate and send the phone OTP
            $phoneOtp = generateOTP(); // Use the function to generate OTP
            $phoneOtpExpiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Store the generated phone OTP in the database
            $stmt = $pdo->prepare('INSERT INTO phone_verifications (phone_number, otp, expiry) VALUES (?, ?, ?)');
            if ($stmt->execute([$phoneNumber, $phoneOtp, $phoneOtpExpiry])) {
                
                // Send OTP via Semaphore API
                $output = sendSemaphoreSMS($phoneNumber, $phoneOtp, $semaphoreApiKey);

                // Check the API response
                $responseArray = json_decode($output, true);
                if (isset($responseArray[0]['status']) && $responseArray[0]['status'] === 'Pending') {
                    // OTP successfully sent via Semaphore
                    $response['success'] = true;
                    $response['message'] = 'OTP verified successfully via email. Please check your phone for the OTP.';
                    $response['phone_otp_status'] = 'OTP sent successfully to ' . $phoneNumber;

                    // Redirect to phone verification page only if SMS was successfully sent
                    $response['redirect'] = 'phone_verification.php';
                } else { 
                    // Failed to send OTP via SMS
                    $response['message'] = 'Failed to send OTP via SMS: ' . print_r($responseArray, true);
                }
            } else {
                $response['message'] = 'Failed to store phone OTP.';
            }
        } else {
            $response['message'] = 'Failed to verify email OTP.';
        }
    } else {
        $response['message'] = 'Invalid email OTP or OTP expired.';
    }
    echo json_encode($response);
}

// Function to generate a random 6-digit OTP
function generateOTP() {
    return strval(mt_rand(100000, 999999));
}

// Function to send Semaphore SMS using cURL
function sendSemaphoreSMS($phoneNumber, $otp, $apiKey) {
    $ch = curl_init();
    $parameters = array(
        'apikey' => $apiKey,
        'number' => $phoneNumber,
        'message' => 'Your OTP for registration is: ' . $otp,
        'sendername' => 'LemeryVet'
    );

    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);

    if ($output === false) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);

    return $output;
}
?>
