<?php
session_start();

// Retrieve schedule_id from the URL
if(isset($_GET['scheduleDeparture_id'])) {
    $scheduleDeparture_id = $_GET['scheduleDeparture_id'];

    $_SESSION['schedule_departure'] = [
        'scheduleDeparture_id' => $_GET['scheduleDeparture_id'],
    ];
}

if(isset($_SESSION['schedule_departure'])) {
    $scheduleDeparture = $_SESSION['schedule_departure'];

    $scheduleDeparture_id = $scheduleDeparture['scheduleDeparture_id'];

    echo "Departure Schedule ID: " . htmlspecialchars($scheduleDeparture_id) . "<br>";
}

// Check if booking details are set in the session
if(isset($_SESSION['booking'])) {
    $booking = $_SESSION['booking'];

    // Access individual values
    $direction = $booking['direction'];
    $destination_from = $booking['destination_from'];
    $destination_to = $booking['destination_to'];
    $date_departure = $booking['date_departure'];
    $date_arrival = $booking['date_arrival'];
    $passenger = $booking['passenger'];

    // You can now use these values in your page
    echo "Direction: " . htmlspecialchars($direction) . "<br>";
    echo "From: " . htmlspecialchars($destination_from) . "<br>";
    echo "To: " . htmlspecialchars($destination_to) . "<br>";
    echo "Departure Date: " . htmlspecialchars($date_departure) . "<br>";
    echo "Arrival Date: " . htmlspecialchars($date_arrival) . "<br>";
    echo "Number of Passengers: " . htmlspecialchars($passenger) . "<br>";
}
?>
