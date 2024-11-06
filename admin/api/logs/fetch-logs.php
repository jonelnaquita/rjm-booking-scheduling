<?php
// Include your database connection file
require '../../../models/conn.php';

$sql = "SELECT tblstaff.staff_id, 
               CONCAT(tblstaff.firstname, ' ', tblstaff.lastname) AS staff_name, 
               tblroutefrom.destination_from, 
               tbllogs.action
        FROM tbllogs
        LEFT JOIN tblstaff ON tbllogs.staff_id = tblstaff.staff_id
        LEFT JOIN tblroutefrom ON tblstaff.terminal = tblroutefrom.from_id";
$result = $conn->query($sql);

$logs = [];
if ($result->num_rows > 0) {
    $count = 1;
    while ($row = $result->fetch_assoc()) {
        $logs[] = [
            'index' => $count++,                    // Keeps a running count
            'staff_name' => $row['staff_name'],      // Staff name
            'destination_from' => $row['destination_from'], // Corrected the field name from 'terminal' to 'destination_from'
            'action' => $row['action']               // Action performed
        ];
    }
}

echo json_encode($logs); // Output the logs in JSON format
$conn->close(); // Close the database connection
?>