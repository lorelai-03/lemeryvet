<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Database connection
    $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

    // Prepare and execute the query
    $stmt = $pdo->prepare('SELECT id FROM medical_products WHERE id = ?');
    $stmt->execute([$id]);

    // Fetch the data
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Return the data as JSON
        echo json_encode($row);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
