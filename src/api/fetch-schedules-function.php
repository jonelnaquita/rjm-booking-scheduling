<?php
require '../../models/conn.php';

// Fetch unique departure dates
function fetchUniqueDates($conn) {
    $query = "SELECT DISTINCT departure_date FROM tblschedule WHERE sched_status = '' ORDER BY departure_date ASC";
    $result = mysqli_query($conn, $query);
    $dates = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dates[] = $row['departure_date'];
    }
    return $dates;
}

// Fetch schedules based on the selected date
function fetchSchedulesByDate($conn, $date, $destination_from, $destination_to) {
    $query = "SELECT s.schedule_id, s.departure_time, s.destination_from, s.destination_to, bt.bus_type, b.seats, s.fare
            FROM tblschedule s
            JOIN tblbus b ON s.bus_id = b.bus_id
            JOIN tblbustype bt ON b.bus_type = bt.bustype_id
            WHERE s.departure_date = '$date'
            AND s.destination_from = '$destination_from'
            AND s.destination_to = '$destination_to'
            AND s.sched_status = ''";
    $result = mysqli_query($conn, $query);
    $schedules = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $schedules[] = $row;
    }
    return $schedules;
}

?>



