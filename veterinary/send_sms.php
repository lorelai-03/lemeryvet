<?php
require_once('vendor/autoload.php');
use Semaphore\SemaphoreClient;

// Your Semaphore API key
$semaphoreApiKey = '32ac987bd908044bb319318827a8a1e0';

// Create a Semaphore client
$client = new SemaphoreClient($semaphoreApiKey);

// Function to send Semaphore SMS
function sendSemaphoreSMS($phoneNumber, $message, $client) {
    $ch = curl_init();
    $parameters = array(
        'apikey' => $client->apiKey,
        'number' => $phoneNumber,
        'message' => $message,
        'sendername' => 'LemeryVet' // Replace with your approved sender name
    );

    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);

    if ($output === false) {
        return 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);

    return $output;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phoneNumber = $_POST['phoneNumber'];
    $smsContent = $_POST['smsContent'];

    // Send the SMS
    $response = sendSemaphoreSMS($phoneNumber, $smsContent, $client);

    // Output response for AJAX request
    echo $response;
}
?>
