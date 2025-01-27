<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    try {
        // Database connection
        $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the status in the database
        $sql = "UPDATE veterinarians SET status = :status WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':user_id' => $user_id,
        ]);

        // Get the veterinarian's email
        $sql = "SELECT email FROM veterinarians WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $email = $stmt->fetchColumn();

        if ($status === 'verified') {
            // Send email notification
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'lemeryvets@gmail.com'; // Your Gmail address
                $mail->Password   = 'rrwmnrjrmngckrgy'; // Use an App Password if you have 2-Step Verification enabled
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

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

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Account Verified';
                $mail->Body    = 'Your account has been verified. You can now log in and use your account.';

                $mail->send();
            } catch (Exception $e) {
                // Handle email sending errors if necessary
            }
        }

        // Send a success response
        echo 'success';
    } catch (PDOException $e) {
        // Send an error response
        echo 'error';
    }
}
