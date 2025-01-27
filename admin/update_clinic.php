<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['clinicId'];
    $businessPermitNo = $_POST['businessPermitNo'];
    $clinicName = $_POST['clinicName'];
    $address = $_POST['address'];
    $lineOfBusiness = $_POST['lineOfBusiness'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $clinicImage = $_FILES['clinicImage']['name'];

    // Handle image upload
    if ($clinicImage) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["clinicImage"]["name"]);
        move_uploaded_file($_FILES["clinicImage"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("UPDATE clinic_info SET businessPermitNo = ?, clinicName = ?, address = ?, lineOfBusiness = ?, latitude = ?, longitude = ?, clinicImage = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $businessPermitNo, $clinicName, $address, $lineOfBusiness, $latitude, $longitude, $target_file, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
