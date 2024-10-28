<?php
session_start();

if(isset($_GET['scheduleDeparture_id'])) {
    $scheduleDeparture_id = $_GET['scheduleDeparture_id'];

    $_SESSION['schedule_departure'] = [
        'scheduleDeparture_id' => $_GET['scheduleDeparture_id'],
    ];
}

if (isset($_SESSION['schedule_departure']) && !empty($_SESSION['schedule_departure'])) {
    $scheduleDeparture = $_SESSION['schedule_departure'];

    // Ensure 'scheduleDeparture_id' is set in the session data
    if (isset($scheduleDeparture['scheduleDeparture_id'])) {
        $scheduleDeparture_id = $scheduleDeparture['scheduleDeparture_id'];
    }
}

// Display the departure schedule ID if available
// echo "Departure Schedule ID: " . (isset($scheduleDeparture_id) ? htmlspecialchars($scheduleDeparture_id) : 'Not available') . "<br>";


// Initialize scheduleArrival_id to zero by default
$scheduleArrival_id = 0; // Default value

// Retrieve 'scheduleArrival_id' from the URL, if it exists
if (isset($_GET['scheduleArrival_id']) && !empty($_GET['scheduleArrival_id'])) {
    $scheduleArrival_id = $_GET['scheduleArrival_id'];

    // Store the retrieved ID in session
    $_SESSION['schedule_arrival'] = [
        'scheduleArrival_id' => $scheduleArrival_id,
    ];
}

// Handle session data for 'schedule'
if (isset($_SESSION['schedule_arrival']) && !empty($_SESSION['schedule_arrival'])) {
    $scheduleArrival = $_SESSION['schedule_arrival'];

    // Ensure 'scheduleArrival_id' is set in the session data
    if (isset($scheduleArrival['scheduleArrival_id']) && !empty($scheduleArrival['scheduleArrival_id'])) {
        $scheduleArrival_id = $scheduleArrival['scheduleArrival_id'];
    } else {
        // If 'scheduleArrival_id' is empty, set it to zero
        $scheduleArrival_id = 0;
    }
}


// Display the arrival schedule ID if available
// echo "Arrival Schedule ID: " . (isset($scheduleArrival_id) ? htmlspecialchars($scheduleArrival_id) : 'Not available') . "<br>";


// Check if booking details are set in the session
if(isset($_SESSION['booking'])) {
    $booking = $_SESSION['booking'];

    $direction = $booking['direction'];
    $destination_from = $booking['destination_from'];
    $destination_to = $booking['destination_to'];
    $date_departure = $booking['date_departure'];
    $date_arrival = $booking['date_arrival'];
    $passenger = $booking['passenger'];

    // Now, you can use these values along with schedule_id
    /*
    echo "Direction: " . htmlspecialchars($direction) . "<br>";
    echo "From: " . htmlspecialchars($destination_from) . "<br>";
    echo "To: " . htmlspecialchars($destination_to) . "<br>";
    echo "Departure Date: " . htmlspecialchars($date_departure) . "<br>";
    echo "Arrival Date: " . htmlspecialchars($date_arrival) . "<br>";
    echo "Number of Passengers: " . htmlspecialchars($passenger) . "<br>";
    **/
}
?>
