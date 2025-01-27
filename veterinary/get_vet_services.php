<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Database connection
        $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the query
        $stmt = $pdo->prepare('SELECT id, veterinary_name, veterinary_description, veterinary_price, veterinary_image FROM veterinary_services WHERE id = ?');
        $stmt->execute([$id]);

        // Fetch the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Return the data as JSON
            echo json_encode($row);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Service not found']);
        }
    } catch (PDOException $e) {
        // Handle potential errors
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
