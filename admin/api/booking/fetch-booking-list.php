<?php
    // SQL query to fetch booking details without conditions
    $sql = "SELECT
            b.book_id AS booking_id,
            b.passenger_id AS book_id,
            CONCAT(p.firstname, ' ', IFNULL(p.middlename, ''), ' ', p.lastname) AS fullname,
            b.trip_type,
            departure_route.destination_from AS departure_destination,
            arrival_route.destination_from AS arrival_destination,
            departure_schedule.departure_date AS departure_date,
            departure_schedule.departure_time AS departure_time,
            arrival_schedule.departure_date AS arrival_date,
            arrival_schedule.departure_time AS arrival_time,
            CONCAT(bus.bus_number, ' - ', bt.bus_type) AS bus_info,
            b.price AS travel_cost,
            b.passengers AS num_passengers,
            b.status,
            py.reference_number,
            py.screenshot_filename
        FROM tblbooking b
        JOIN tblpassenger p ON b.passenger_id = p.passenger_code
        JOIN tblschedule departure_schedule ON b.scheduleDeparture_id = departure_schedule.schedule_id
        JOIN tblschedule arrival_schedule ON b.scheduleArrival_id = arrival_schedule.schedule_id
        JOIN tblroutefrom departure_route ON departure_schedule.destination_from = departure_route.from_id
        JOIN tblroutefrom arrival_route ON arrival_schedule.destination_from = arrival_route.from_id
        JOIN tblbus bus ON departure_schedule.bus_id = bus.bus_id
        JOIN tblbustype bt ON bus.bus_type = bt.bustype_id
        LEFT JOIN tblpayment py ON b.passenger_id = py.passenger_id
        WHERE b.status = 'Pending'
        ORDER BY departure_date DESC";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $count = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr class='tr-shadow'>";
            echo "<td>" . $count . "</td>";
            echo "<td>" . $row['book_id'] . "</td>";
            echo "<td>" . strtoupper($row['fullname']) . "</td>";
            
            // Condition for destination
            if ($row['trip_type'] == 'Round-Trip') {
                echo "<td> <div class='badge badge-primary badge-pill mb-2'>" . $row['departure_destination'] . " to " . $row['arrival_destination'] . "</div> <br> <div class='badge badge-primary badge-pill'>" . $row['arrival_destination'] . " to " . $row['departure_destination'] . "</div></td>";
            } else {
                echo "<td> <div class='badge badge-primary badge-pill'>" . $row['departure_destination'] . "</div></td>";
            }
            
            // Condition for schedule
            if ($row['trip_type'] == 'Round-Trip') {
                echo "<td> <div class='badge badge-primary badge-pill mb-2'>" . $row['departure_date'] . " " . $row['departure_time'] . " (Departure)</div> <br> <div class='badge badge-primary badge-pill'>" . 
                        $row['arrival_date'] . " " . $row['arrival_time'] . " (Arrival)</div></td>";
            } else {
                echo "<td> <div class='badge badge-primary badge-pill'>" . $row['departure_date'] . " " . $row['departure_time'] . "</div></td>";
            }
            
            echo "<td>" . $row['bus_info'] . "</td>";
            echo "<td>₱" . number_format($row['travel_cost'], 2) . "</td>";
            echo "<td> <div class='badge badge-pill badge-outline-primary'>" . $row['num_passengers'] . "</div></td>";
            echo "<td> <div class='badge badge-info badge-pill'>" . $row['status'] . "</div></td>";
            echo "<td>
                    <div class='table-data-feature'>
                        <button type='button'
                            class='btn btn-primary btn-accept btn-rounded btn-fw'
                            data-bs-toggle='modal'
                            data-bs-target='#accept-booking-modal'
                            data-book-id='{$row['book_id']}' 
                            style='margin-right: 5px;'>Accept</button>
                        <button type='button' class='btn btn-light btn-rounded btn-fw'>Cancel</button>
                    </div>
                </td>";
            echo "</tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='10'>No bookings found</td></tr>";
    }
?>
