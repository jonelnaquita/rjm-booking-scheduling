<?php
include '../../../models/conn.php';

$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

$data = [
    'totalBookings' => 0,
    'todaysBookings' => 0,
    'totalPassengers' => 0,
    'totalRevenue' => 0
];

// Total confirmed bookings for the selected month and year
$totalBookingsQuery = "SELECT COUNT(*) AS totalBookings 
                       FROM tblbooking 
                       WHERE status = 'Confirmed' 
                         AND YEAR(date_created) = '$year' 
                         AND MONTH(date_created) = '$month'";
$totalBookingsResult = mysqli_query($conn, $totalBookingsQuery);
$data['totalBookings'] = $totalBookingsResult ? mysqli_fetch_assoc($totalBookingsResult)['totalBookings'] : 0;

// Today's bookings
$todaysDate = date('Y-m-d');
$todaysBookingsQuery = "SELECT COUNT(*) AS todaysBookings 
                        FROM tblbooking 
                        WHERE DATE(date_created) = '$todaysDate'";
$todaysBookingsResult = mysqli_query($conn, $todaysBookingsQuery);
$data['todaysBookings'] = $todaysBookingsResult ? mysqli_fetch_assoc($todaysBookingsResult)['todaysBookings'] : 0;

// Total passengers for the selected month and year
$totalPassengersQuery = "SELECT SUM(passengers) AS totalPassengers 
                         FROM tblbooking 
                         WHERE status = 'Confirmed' 
                           AND YEAR(date_created) = '$year' 
                           AND MONTH(date_created) = '$month'";
$totalPassengersResult = mysqli_query($conn, $totalPassengersQuery);
$data['totalPassengers'] = $totalPassengersResult ? mysqli_fetch_assoc($totalPassengersResult)['totalPassengers'] : 0;

// Total revenue for the selected month and year
$totalRevenueQuery = "SELECT SUM(price) AS totalRevenue 
                      FROM tblbooking 
                      WHERE status = 'Confirmed' 
                        AND YEAR(date_created) = '$year' 
                        AND MONTH(date_created) = '$month'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$data['totalRevenue'] = $totalRevenueResult ? mysqli_fetch_assoc($totalRevenueResult)['totalRevenue'] : 0;

header('Content-Type: application/json');
echo json_encode($data);
?>