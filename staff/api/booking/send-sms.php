<?php
function sendSMS($number, $message)
{
    $ch = curl_init();

    // Define your API key and sender name here
    $apiKey = 'f65291a797424a4ff2e7c424ceac99c0'; // Your API KEY
    $senderName = 'RJM';

    // Set up parameters for the request
    $parameters = array(
        'apikey' => $apiKey,
        'number' => $number,
        'message' => $message,
        'sendername' => $senderName
    );

    // Set cURL options for the API request
    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request and store the response
    $output = curl_exec($ch);

    // Check for errors
    if ($output === false) {
        return "Error: " . curl_error($ch);
    }

    curl_close($ch);

    // Decode the API response to check for success or error
    $response = json_decode($output, true);

    // Check if response contains a success status
    if (isset($response['status']) && $response['status'] === 'success') {
        return "Success: Message sent successfully.";
    } else {
        // Return the error message if available
        return "Error: " . ($response['message'] ?? 'Unknown error occurred.');
    }
}
?>