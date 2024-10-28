<?php
session_start();
include '../../../models/conn.php'; // Ensure this path is correct

// Get the staff_id from session
$staff_id = $_SESSION['staff'];

// Fetch the terminal associated with the staff from tblstaff
$terminalQuery = "SELECT terminal FROM tblstaff WHERE staff_id = ?";
$stmt = $conn->prepare($terminalQuery);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$resultTerminal = $stmt->get_result();

if ($resultTerminal->num_rows > 0) {
    $rowTerminal = $resultTerminal->fetch_assoc();
    $terminal_id = $rowTerminal['terminal'];
} else {
    echo json_encode(['error' => 'Terminal not found']);
    exit();
}

// SQL query to count bookings by status filtered by terminal
$query = "
    SELECT 
        tblbooking.status, 
        COUNT(*) AS count 
    FROM 
        tblbooking
    JOIN tblschedule ON tblbooking.scheduleDeparture_id = tblschedule.schedule_id OR tblbooking.scheduleArrival_id = tblschedule.schedule_id
    JOIN tblroutefrom ON tblschedule.destination_from = tblroutefrom.from_id
    WHERE tblroutefrom.from_id = ? AND tblbooking.status = 'Confirmed'
    GROUP BY 
        tblbooking.status;
";

// Prepare and execute the query with the terminal_id
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $terminal_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize the booking count array
$bookingCounts = [
    'confirmed' => 0,
    'pending' => 0,
    'cancelled' => 0,
];

// Populate the booking counts based on the result
while ($row = $result->fetch_assoc()) {
    $status = strtolower($row['status']); // Convert status to lowercase
    if (isset($bookingCounts[$status])) {
        $bookingCounts[$status] = (int)$row['count'];
    }
}

// Close connection and return data
$stmt->close();
$conn->close();

echo json_encode($bookingCounts);
?>
