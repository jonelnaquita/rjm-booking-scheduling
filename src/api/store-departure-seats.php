<?php
// Start session
session_start();

// Initialize response array
$response = array('success' => false);

// Check if 'seats' is posted
if (isset($_POST['departure_seats'])) {
    // Decode the JSON seats array
    $seats = json_decode($_POST['departure_seats'], true);

    // Perform server-side validation if needed

    // Assuming $seats is an array and you want to store it in the session
    $_SESSION['departure_seats'] = $seats;

    // Set success to true if everything goes well
    $response['success'] = true;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
