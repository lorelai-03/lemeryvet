<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost'; // Your database host
$dbname = 'u104053626_lemeryvetcare'; // Your database name
$username = 'u104053626_lemeryvetcare'; // Your database username
$password = 'Lemeryvet4209*'; // Your database password

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to fetch data
    $stmt = $pdo->query("SELECT latitude, longitude, clinic_name, address, clinic_image FROM clinic_info");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format the data
    $formattedLocations = array_map(function($location) {
        return [
            'lat' => $location['latitude'],
            'lng' => $location['longitude'],
            'title' => $location['clinic_name'],
            'description' => $location['address'],
            'imgSrc' => $location['clinic_image']
        ];
    }, $locations);
    
    echo json_encode($formattedLocations);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
