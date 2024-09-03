<?php
require 'fetch-schedules-function.php';

$date = isset($_GET['date']) ? $_GET['date'] : '';
$destination_from = isset($_GET['destination_from']) ? $_GET['destination_from'] : '';
$destination_to = isset($_GET['destination_to']) ? $_GET['destination_to'] : '';

$schedules = fetchSchedulesByDate($conn, $date, $destination_from, $destination_to);
echo json_encode($schedules);
?>
