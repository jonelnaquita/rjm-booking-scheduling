<?php
    include '../../models/conn.php'; // Adjust the path to your database connection file

    $query = "
        SELECT 
            s.schedule_id,
            rf.destination_from,
            s.departure_date,
            s.departure_time,
            b.bus_number,
            bt.bus_type,
            s.sched_status,
            trf.destination_from AS trip_to
        FROM 
            tblschedule s
        JOIN 
            tblroutefrom rf ON s.destination_from = rf.from_id
        JOIN 
            tblroutefrom trf ON s.destination_to = trf.from_id
        JOIN 
            tblbus b ON s.bus_id = b.bus_id
        JOIN 
            tblbustype bt ON b.bus_type = bt.bustype_id
        WHERE
            s.sched_status = 'Archived'
        ORDER BY 
            s.departure_date DESC
    ";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $counter = 1;
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>";
            echo "<td> <label class='badge badge-info'>". htmlspecialchars($row['destination_from']) ."</label></td>";
            echo "<td> <label class='badge badge-info'>". htmlspecialchars($row['trip_to']) ."</label></td>";
            echo "<td>" . date('F j, Y', strtotime($row['departure_date'])) . "</td>";
            echo "<td>" . date('h:i A', strtotime($row['departure_time'])) . "</td>";
            echo "<td>" . htmlspecialchars($row['bus_number']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bus_type']) . "</td>";
            echo "<td> <label class='badge badge-success'>". htmlspecialchars($row['sched_status']) ."</label></td>";
            echo "</tr>";
            $counter++;
        }
    }

    mysqli_close($conn);
?>
