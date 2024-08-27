<?php
// Include database connection
include '../../models/conn.php';

// Fetch the pickup_location value from the hidden input
$pickup_id = isset($_POST['pickup_id']) ? intval($_POST['pickup_id']) : 0;

// Fetch registered destinations for the given pickup_id
$registeredDestinationsQuery = "
    SELECT rto.from_id, rto.destination_to AS destination_id
        FROM tblroutefrom rfrom
        LEFT JOIN tblrouteto rto ON rfrom.from_id = rto.destination_to
        WHERE rto.from_id = ? AND rfrom.from_id = rto.destination_to;
";
$registeredStmt = $conn->prepare($registeredDestinationsQuery);
$registeredStmt->bind_param("i", $pickup_id);
$registeredStmt->execute();
$registeredResult = $registeredStmt->get_result();

// Collect registered destination IDs
$registeredDestinations = [];
while ($row = $registeredResult->fetch_assoc()) {
    $registeredDestinations[] = $row['destination_id'];
}

// Fetch all route from data
$dropOffQuery = "
    SELECT from_id, destination_from
    FROM tblroutefrom
";
$dropOffResult = $conn->query($dropOffQuery);

// Prepare available destinations
$availableDestinations = [];
while ($row = $dropOffResult->fetch_assoc()) {
    $from_id = $row['from_id'];
    $destination_from = $row['destination_from'];

    // Determine if this destination is registered
    $isRegistered = in_array($from_id, $registeredDestinations);

    $availableDestinations[] = [
        'from_id' => $from_id,
        'destination_from' => $destination_from,
        'disabled' => $isRegistered
    ];
}

// Send available destinations as JSON
echo json_encode($availableDestinations);
?>
