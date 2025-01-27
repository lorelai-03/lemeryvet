<?php
// Database connection
require 'config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phoneOtp = $_POST['phoneOtp'];

    // Validate phone OTP
    $stmt = $pdo->prepare('SELECT * FROM phone_verifications WHERE otp = ? AND expiry > NOW()');
    $stmt->execute([$phoneOtp]);

    if ($stmt->rowCount() > 0) {
        $verification = $stmt->fetch();
        $phoneNumber = $verification['phone_number'];

        // Update user status to verified
        $stmt = $pdo->prepare('UPDATE users SET phone_verified = 1 WHERE phone_number = ?');
        if ($stmt->execute([$phoneNumber])) {
            $response['success'] = true;
            $response['message'] = 'Phone number verified successfully.';
        } else {
            $response['message'] = 'Failed to verify phone number.';
        }
    } else {
        $response['message'] = 'Invalid OTP or OTP expired.';
    }

    echo json_encode($response);
}
?>
