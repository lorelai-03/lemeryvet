<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Count records in each table
    $medicalCount = $pdo->query("SELECT COUNT(*) FROM medical_products")->fetchColumn();
    $serviceCount = $pdo->query("SELECT COUNT(*) FROM veterinary_services")->fetchColumn();
    $petCount = $pdo->query("SELECT COUNT(*) FROM pet_products")->fetchColumn();

    $data = [
        'medical_count' => $medicalCount,
        'service_count' => $serviceCount,
        'pet_count' => $petCount
    ];

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
