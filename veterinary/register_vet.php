<?php
// Include database configuration
include 'pdo_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Access form fields
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $clinic_name = $_POST['clinic_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];

    // Initialize file paths
    $vetLicensePath = '';
    $businessPermitPath = '';

    // Handle file uploads
    if (isset($_FILES['vet_license']) && $_FILES['vet_license']['error'] == UPLOAD_ERR_OK) {
        $vetLicensePath = 'uploads/' . basename($_FILES['vet_license']['name']);
        move_uploaded_file($_FILES['vet_license']['tmp_name'], $vetLicensePath);
    }

    if (isset($_FILES['business_permit']) && $_FILES['business_permit']['error'] == UPLOAD_ERR_OK) {
        $businessPermitPath = 'uploads/' . basename($_FILES['business_permit']['name']);
        move_uploaded_file($_FILES['business_permit']['tmp_name'], $businessPermitPath);
    }

    // Check if passwords match
    if ($password !== $retype_password) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query
    $sql = "INSERT INTO veterinarians (fullname, gender, dob, clinic_name, address, email, password, vet_license, business_permit, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        // Prepare and execute the statement
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fullname, $gender, $dob, $clinic_name, $address, $email, $hashedPassword, $vetLicensePath, $businessPermitPath, 'unverified']);

        // Return success response
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // Handle SQL errors
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
