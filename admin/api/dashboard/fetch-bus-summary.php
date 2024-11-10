<?php
include '../../../models/conn.php'; // Adjust to your DB connection

$year = isset($_GET['year']) ? (int) $_GET['year'] : date('Y');

$query = "
    SELECT 
        tblbustype.bus_type, 
        MONTH(tblschedule.departure_date) AS booking_month, 
        COUNT(tblbooking.book_id) AS total_bookings
    FROM tblbooking
    INNER JOIN tblschedule ON (
        tblbooking.scheduleDeparture_id = tblschedule.schedule_id
        OR tblbooking.scheduleArrival_id = tblschedule.schedule_id
    )
    INNER JOIN tblbus ON tblschedule.bus_id = tblbus.bus_id
    INNER JOIN tblbustype ON tblbus.bus_type = tblbustype.bustype_id
    WHERE YEAR(tblschedule.departure_date) = $year 
    GROUP BY tblbustype.bus_type, MONTH(tblschedule.departure_date)
    ORDER BY MONTH(tblschedule.departure_date);
";

$result = mysqli_query($conn, $query);

$busTypesData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $busTypesData[$row['bus_type']][$row['booking_month']] = $row['total_bookings'];
}

// Return the data as JSON
echo json_encode($busTypesData);
?>