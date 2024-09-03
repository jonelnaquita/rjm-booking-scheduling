<?php
session_start();

// Store form data in the session
$_SESSION['booking'] = [
    'direction' => $_POST['direction'],
    'destination_from' => $_POST['destination-from'],
    'destination_to' => $_POST['destination-to'],
    'date_departure' => $_POST['date-departure'],
    'date_arrival' => $_POST['date-arrival'],
    'passenger' => $_POST['passenger']
];

// Redirect to the schedules page
header("Location: ../pages/schedules.php");
exit();
?>
