<?php
require '../../models/conn.php';

// Fetch unique departure dates
function fetchUniqueDates($conn)
{
    $query = "SELECT DISTINCT departure_date FROM tblschedule WHERE sched_status = '' ORDER BY departure_date ASC";
    $result = mysqli_query($conn, $query);
    $dates = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dates[] = $row['departure_date'];
    }
    return $dates;
}

// Fetch schedules based on the selected date
function fetchSchedulesByDate($conn, $date, $destination_from, $destination_to, $bus_type)
{
    $query = "SELECT s.schedule_id, s.departure_time, s.destination_from, s.destination_to, bt.bus_type, 
                     b.seats AS total_seats, 
                     (b.seats - COUNT(ts.seat_id)) AS available_seats, 
                     s.fare
              FROM tblschedule s
              LEFT JOIN tblbus b ON s.bus_id = b.bus_id
              LEFT JOIN tblbustype bt ON b.bus_type = bt.bustype_id
              LEFT JOIN tblseats ts ON s.schedule_id = ts.schedule_id
              WHERE s.departure_date = '$date'
              AND s.destination_from = '$destination_from'
              AND s.destination_to = '$destination_to'
              AND bt.bustype_id = '$bus_type'
              AND s.sched_status = ''
              GROUP BY s.schedule_id, s.departure_time, s.destination_from, s.destination_to, bt.bus_type, b.seats, s.fare";

    $result = mysqli_query($conn, $query);
    $schedules = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $schedules[] = $row;
    }
    return $schedules;
}



?>