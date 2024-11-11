<?php
// Include your database connection file
require '../../../models/conn.php';

// Check if a date filter is set
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';

// SQL query to fetch logs
$sql = "SELECT tblstaff.staff_id, 
               CONCAT(tblstaff.firstname, ' ', tblstaff.lastname) AS staff_name, 
               tbllogs.role,
               tblroutefrom.destination_from, 
               tbllogs.action,
               tbllogs.date_created
        FROM tbllogs
        LEFT JOIN tblstaff ON tbllogs.staff_id = tblstaff.staff_id
        LEFT JOIN tblroutefrom ON tblstaff.terminal = tblroutefrom.from_id";

// If a date filter is provided, modify the SQL query
if ($date_filter) {
    $formattedDate = DateTime::createFromFormat('m/d/Y', $date_filter)->format('Y-m-d');
    $sql .= " WHERE DATE(tbllogs.date_created) = '$formattedDate'";
}

$result = $conn->query($sql);

$logs = [];
if ($result->num_rows > 0) {
    $count = 1;
    while ($row = $result->fetch_assoc()) {
        // Format the date_created field to the desired format
        $formattedDate = date('F j, Y g:i A', strtotime($row['date_created']));

        // Check the role: if role is 'Admin', show "Admin" for staff_name
        // If role is 'Terminal Staff', show the staff's full name
        if ($row['role'] == 'Admin') {
            $staff_name = 'Admin';
            $destination_from = 'Main Office'; // Show "Main Office" for Admin
        } else {
            // For Terminal Staff, show destination_from if not null
            $staff_name = $row['staff_name'];
            $destination_from = !empty($row['destination_from']) ? $row['destination_from'] : '';
        }

        $logs[] = [
            'index' => $count++,                    // Keeps a running count
            'staff_name' => $staff_name,             // Show "Admin" or actual staff name
            'destination_from' => $destination_from, // Show destination based on role
            'action' => $row['action'],
            'date_created' => $formattedDate         // Action performed with formatted date
        ];
    }
}

// Debugging: Output the raw JSON data to check
header('Content-Type: application/json');
echo json_encode($logs); // Output the logs in JSON format
$conn->close(); // Close the database connection
?>