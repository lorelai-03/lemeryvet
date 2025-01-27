<?php
// fetch_users.php
$servername = "localhost";
$username = "u104053626_lemeryvetcare";
$password = "Lemeryvet4209*";
$dbname = "u104053626_lemeryvetcare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, full_name, phone_number FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);

$conn->close();
?>
