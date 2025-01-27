<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Database connection
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the query
        $stmt = $pdo->prepare('SELECT id, pet_name, pet_description, pet_price, pet_image FROM pet_products WHERE id = ?');
        $stmt->execute([$id]);

        // Fetch the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Return the data as JSON
            echo json_encode($row);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
