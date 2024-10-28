<?php
include '../../../models/conn.php';

if (isset($_POST['schedule_id']) && isset($_POST['booking_id'])) {
    $schedule_id = $_POST['schedule_id'];
    $booking_id = $_POST['booking_id'];

    // Query to fetch the number of passengers for the given booking_id
    $queryPassengerCount = "SELECT passengers FROM tblbooking WHERE book_id = '$booking_id'";
    $resultPassengerCount = mysqli_query($conn, $queryPassengerCount);

    if ($resultPassengerCount && mysqli_num_rows($resultPassengerCount) > 0) {
        $row = mysqli_fetch_assoc($resultPassengerCount);
        $passengerCount = $row['passengers'];
    }

    // Query to fetch the total number of seats from tblbus based on the schedule
    $queryBusSeats = "
        SELECT b.seats 
        FROM tblschedule s
        JOIN tblbus b ON s.bus_id = b.bus_id
        WHERE s.schedule_id = '$schedule_id'
    ";
    $resultBusSeats = mysqli_query($conn, $queryBusSeats);
    $totalSeats = 45;  // Default value
    if ($resultBusSeats && mysqli_num_rows($resultBusSeats) > 0) {
        $row = mysqli_fetch_assoc($resultBusSeats);
        $totalSeats = $row['seats'];
    }

    // Query to fetch booked seat numbers and booking statuses for the given schedule_id
    $querySeats = "SELECT s.seat_number, b.status 
                   FROM tblseats s
                   LEFT JOIN tblbooking b ON s.passenger_id = b.passenger_id
                   WHERE s.schedule_id = '$schedule_id'";
    
    $resultSeats = mysqli_query($conn, $querySeats);
    
    $bookedSeats = [];
    if ($resultSeats) {
        while ($row = mysqli_fetch_assoc($resultSeats)) {
            $seatNumber = $row['seat_number'];
            $status = $row['status'];
            $bookedSeats[$seatNumber] = $status;
        }
    }

    // Prepare the response with the booked seats, passenger count, and total seats
    $response = [
        'seats' => $bookedSeats,
        'passenger_count' => $passengerCount,
        'total_seats' => $totalSeats
    ];

    // Return the response as JSON
    echo json_encode($response);
}
?>
