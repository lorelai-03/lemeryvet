<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=db_veterinary_clinic;charset=utf8", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE veterinarians SET status = :status WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':user_id' => $user_id,
        ]);

        // Send a success response
        echo 'success';
    } catch (PDOException $e) {
        // Send an error response
        echo 'error';
    }
}
