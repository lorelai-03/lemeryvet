<?php 
require_once('db.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['success' => false, 'message' => 'Error: No data to save.']);
    $conn->close();
    exit;
}

extract($_POST);

// Check if full_name is set and sanitize it
$full_name = isset($full_name) ? $conn->real_escape_string($full_name) : '';

if (empty($id)) {
    // Insert new record
    $sql = "INSERT INTO `schedule_list` (`title`, `description`, `start_datetime`, `end_datetime`, `veterinaryId`, `medicalName`, `full_name`) 
            VALUES ('$title', '$description', '$start_datetime', '$end_datetime', '$veterinaryId', '$medicalName', '$full_name')";
    $action = 'saved';
} else {
    // Update existing record
    $sql = "UPDATE `schedule_list` 
            SET `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', 
                `end_datetime` = '{$end_datetime}', `veterinaryId` = '{$veterinaryId}', `medicalName` = '{$medicalName}', 
                `full_name` = '{$full_name}' 
            WHERE `id` = '{$id}'";
    $action = 'updated';
}

$save = $conn->query($sql);

if ($save) {
    echo json_encode(['success' => true, 'action' => $action]);
} else {
    echo json_encode(['success' => false, 'message' => "An Error occurred.\nError: " . $conn->error . "\nSQL: " . $sql]);
}

$conn->close();
?>
