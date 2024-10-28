<?php
include '../../../models/conn.php'; // Adjust your path to the database connection

// Initialize the response array
$data = [
    'totalBookings' => 0,
    'todaysBookings' => 0,
    'totalPassengers' => 0,
    'totalRevenue' => 0
];

// Get total number of bookings
$totalBookingsQuery = "SELECT COUNT(*) AS totalBookings FROM tblbooking WHERE status = 'Confirmed'";
$totalBookingsResult = mysqli_query($conn, $totalBookingsQuery);

if ($totalBookingsResult) {
    $totalBookings = mysqli_fetch_assoc($totalBookingsResult)['totalBookings'];
    $data['totalBookings'] = $totalBookings;
} else {
    error_log("Error fetching total bookings: " . mysqli_error($conn)); // Log any SQL errors
}

// Get today's bookings
$todaysDate = date('Y-m-d');
$todaysBookingsQuery = "SELECT COUNT(*) AS todaysBookings FROM tblbooking WHERE DATE(date_created) = '$todaysDate'";
$todaysBookingsResult = mysqli_query($conn, $todaysBookingsQuery);

if ($todaysBookingsResult) {
    $todaysBookings = mysqli_fetch_assoc($todaysBookingsResult)['todaysBookings'];
    $data['todaysBookings'] = $todaysBookings;
} else {
    error_log("Error fetching today's bookings: " . mysqli_error($conn));
}

// Get the total number of passengers
$totalPassengersQuery = "SELECT SUM(passengers) AS totalPassengers FROM tblbooking WHERE status = 'Confirmed'";
$totalPassengersResult = mysqli_query($conn, $totalPassengersQuery);

if ($totalPassengersResult) {
    $totalPassengers = mysqli_fetch_assoc($totalPassengersResult)['totalPassengers'];
    $data['totalPassengers'] = $totalPassengers;
} else {
    error_log("Error fetching total passengers: " . mysqli_error($conn));
}

// Get total revenue
$totalRevenueQuery = "SELECT SUM(price) AS totalRevenue FROM tblbooking WHERE status = 'Confirmed'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);

if ($totalRevenueResult) {
    $totalRevenue = mysqli_fetch_assoc($totalRevenueResult)['totalRevenue'];
    $data['totalRevenue'] = $totalRevenue;
} else {
    error_log("Error fetching total revenue: " . mysqli_error($conn));
}

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>
