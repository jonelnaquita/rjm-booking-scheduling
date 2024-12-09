<?php
require 'fetch-schedules-function.php';

$date = isset($_GET['date']) ? $_GET['date'] : '';
$destination_from = isset($_GET['destination_from']) ? $_GET['destination_from'] : '';
$destination_to = isset($_GET['destination_to']) ? $_GET['destination_to'] : '';
$bus_type = isset($_GET['bus_type']) ? $_GET['bus_type'] : ''; // Capture bus type

$schedules = fetchSchedulesByDate($conn, $date, $destination_from, $destination_to, $bus_type);
echo json_encode($schedules);
?>