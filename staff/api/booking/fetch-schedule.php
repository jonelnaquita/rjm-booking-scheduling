<?php
include '../../../models/conn.php'; // Your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $destination_from = $_POST['destination_from'];
    $destination_to = $_POST['destination_to'];
    $bus_type = $_POST['bus_type'];

    // SQL Query to fetch schedule details
    $sql = "SELECT s.schedule_id, s.departure_time, bt.bus_type, 
                   b.seats AS total_seats, 
                   (b.seats - COUNT(ts.seat_id)) AS available_seats, 
                   s.fare
            FROM tblschedule s
            JOIN tblbus b ON s.bus_id = b.bus_id
            JOIN tblbustype bt ON b.bus_type = bt.bustype_id
            LEFT JOIN tblseats ts ON s.schedule_id = ts.schedule_id
            WHERE s.departure_date = '$date'
            AND s.destination_from = '$destination_from'
            AND s.destination_to = '$destination_to'
            AND bt.bustype_id = '$bus_type'
            AND s.sched_status = ''
            GROUP BY s.schedule_id, s.departure_time, bt.bus_type, b.seats, s.fare";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $departure_time = date("h:i A", strtotime($row['departure_time']));
            $fare_in_peso = '₱' . number_format($row['fare'], 2);
            
            echo "<tr>
                    <td>{$departure_time}</td>
                    <td>{$row['bus_type']}</td>
                    <td>{$row['available_seats']}</td>
                    <td>{$fare_in_peso}</td>
                    <td><button class='btn btn-sm btn-primary btn-book' data-id='{$row['schedule_id']}'>Select</button></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No schedules found</td></tr>";
    }
}
?>
