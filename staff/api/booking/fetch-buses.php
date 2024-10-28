<?php
include '../../../models/conn.php'; // Adjust the path to your database connection

// Initialize an empty response array
$response = array();

$query = "SELECT bus_id, bus_number FROM tblbus";
$result = mysqli_query($conn, $query);

if ($result) {
    $buses = array();
    
    // Fetch all bus records
    while ($row = mysqli_fetch_assoc($result)) {
        $buses[] = array(
            'bus_id' => $row['bus_id'],
            'bus_number' => $row['bus_number']
        );
    }

    // Prepare a success response
    $response['success'] = true;
    $response['data'] = $buses;
} else {
    // If there was a query error
    $response['success'] = false;
    $response['error'] = 'Error fetching buses from the database';
}

// Return the JSON response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
