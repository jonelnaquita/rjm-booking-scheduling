<?php
require '../../models/conn.php';

// Join query to fetch departure_date, departure_time, and bus_type
$query = "
    SELECT s.departure_date, s.departure_time, bt.bus_type, b.seats
    FROM tblschedule s
    JOIN tblbus b ON s.bus_id = b.bus_id
    JOIN tblbustype bt ON b.bus_type = bt.bustype_id
    WHERE s.schedule_id = '$scheduleDeparture_id'
";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $departure_date = $row['departure_date'];
    $departure_time = $row['departure_time'];
    $bus_type = $row['bus_type'];
    $seats = $row['seats'];
} else {
    $departure_date = "Unknown Date";
    $departure_time = "Unknown Time";
    $bus_type = "Unknown Bus Type";
    $seats = "Unknown Bus Type";
}
?>