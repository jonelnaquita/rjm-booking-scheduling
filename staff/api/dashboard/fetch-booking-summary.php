<?php
include '../../../models/conn.php'; // Adjust your path to the database connection

// Initialize the response array
$data = [
    'totalBookings' => 0,
    'todaysBookings' => 0,
    'totalPassengers' => 0,
    'totalRevenue' => 0
];

// Get terminal ID from the request
$terminal_id = isset($_GET['terminal_id']) ? intval($_GET['terminal_id']) : 0;

// Get total number of bookings filtered by terminal
$totalBookingsQuery = "
    SELECT COUNT(*) AS totalBookings 
    FROM tblbooking 
    LEFT JOIN tblschedule ON tblbooking.scheduleDeparture_id = tblschedule.schedule_id OR tblbooking.scheduleArrival_id = tblschedule.schedule_id
    LEFT JOIN tblroutefrom ON tblschedule.destination_from = tblroutefrom.from_id
    WHERE tblroutefrom.from_id = ? AND tblbooking.status = 'Confirmed' 
";

$totalBookingsStmt = $conn->prepare($totalBookingsQuery);
$totalBookingsStmt->bind_param("i", $terminal_id);
$totalBookingsStmt->execute();
$totalBookingsResult = $totalBookingsStmt->get_result();

if ($totalBookingsResult) {
    $totalBookings = $totalBookingsResult->fetch_assoc()['totalBookings'];
    $data['totalBookings'] = $totalBookings;
} else {
    error_log("Error fetching total bookings: " . mysqli_error($conn)); // Log any SQL errors
}

// Get today's bookings filtered by terminal
$todaysDate = date('Y-m-d');
$todaysBookingsQuery = "
    SELECT COUNT(*) AS todaysBookings 
    FROM tblbooking 
    JOIN tblschedule ON tblbooking.scheduleDeparture_id = tblschedule.schedule_id OR tblbooking.scheduleArrival_id = tblschedule.schedule_id
    JOIN tblroutefrom ON tblschedule.destination_from = tblroutefrom.from_id
    WHERE DATE(tblbooking.date_created) = ? AND tblroutefrom.from_id = ? AND tblbooking.status = 'Confirmed'
";
$todaysBookingsStmt = $conn->prepare($todaysBookingsQuery);
$todaysBookingsStmt->bind_param("si", $todaysDate, $terminal_id);
$todaysBookingsStmt->execute();
$todaysBookingsResult = $todaysBookingsStmt->get_result();

if ($todaysBookingsResult) {
    $todaysBookings = $todaysBookingsResult->fetch_assoc()['todaysBookings'];
    $data['todaysBookings'] = $todaysBookings;
} else {
    error_log("Error fetching today's bookings: " . mysqli_error($conn));
}

// Get the total number of passengers filtered by terminal
$totalPassengersQuery = "
    SELECT SUM(passengers) AS totalPassengers 
    FROM tblbooking 
    JOIN tblschedule ON tblbooking.scheduleDeparture_id = tblschedule.schedule_id OR tblbooking.scheduleArrival_id = tblschedule.schedule_id
    JOIN tblroutefrom ON tblschedule.destination_from = tblroutefrom.from_id
    WHERE tblroutefrom.from_id = ? AND tblbooking.status = 'Confirmed'
";
$totalPassengersStmt = $conn->prepare($totalPassengersQuery);
$totalPassengersStmt->bind_param("i", $terminal_id);
$totalPassengersStmt->execute();
$totalPassengersResult = $totalPassengersStmt->get_result();

if ($totalPassengersResult) {
    $totalPassengers = $totalPassengersResult->fetch_assoc()['totalPassengers'];
    $data['totalPassengers'] = $totalPassengers;
} else {
    error_log("Error fetching total passengers: " . mysqli_error($conn));
}

// Get total revenue filtered by terminal
$totalRevenueQuery = "
    SELECT SUM(price) AS totalRevenue 
    FROM tblbooking 
    JOIN tblschedule ON tblbooking.scheduleDeparture_id = tblschedule.schedule_id OR tblbooking.scheduleArrival_id = tblschedule.schedule_id
    JOIN tblroutefrom ON tblschedule.destination_from = tblroutefrom.from_id
    WHERE tblroutefrom.from_id = ? AND tblbooking.status = 'Confirmed'
";
$totalRevenueStmt = $conn->prepare($totalRevenueQuery);
$totalRevenueStmt->bind_param("i", $terminal_id);
$totalRevenueStmt->execute();
$totalRevenueResult = $totalRevenueStmt->get_result();

if ($totalRevenueResult) {
    $totalRevenue = $totalRevenueResult->fetch_assoc()['totalRevenue'];
    $data['totalRevenue'] = $totalRevenue;
} else {
    error_log("Error fetching total revenue: " . mysqli_error($conn));
}

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>