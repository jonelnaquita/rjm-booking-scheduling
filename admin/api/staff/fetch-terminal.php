<?php
include_once '../../../models/conn.php'; // Update the path to your database connection

header('Content-Type: application/json');

$response = [];

// Fetch terminals
$terminalSql = "SELECT from_id, destination_from FROM tblroutefrom";
$terminalResult = $conn->query($terminalSql);
$terminals = [];

while ($row = $terminalResult->fetch_assoc()) {
    $terminals[] = $row;
}

// Fetch bus numbers
$busSql = "SELECT bus_id, bus_number FROM tblbus";
$busResult = $conn->query($busSql);
$buses = [];

while ($row = $busResult->fetch_assoc()) {
    $buses[] = $row;
}

$response['terminals'] = $terminals;
$response['buses'] = $buses;

echo json_encode($response);
?>
