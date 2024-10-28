<?php
include '../../models/conn.php'; // Adjust the path to your database connection file

// Initialize an array to keep track of duplicates
$duplicate_entries = [];

$query = "
    SELECT 
        s.schedule_id,
        rf.destination_from,
        s.departure_date,
        s.departure_time,
        b.bus_number,
        bt.bus_type,
        b.status,
        s.sched_status,
        s.fare,
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
        s.sched_status = '' AND rf.from_id = $terminal
    ORDER BY 
        s.departure_date ASC
";

// Run the query
$result = mysqli_query($conn, $query);

$schedules = [];
if (mysqli_num_rows($result) > 0) {
    // First, fetch all results into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $schedules[] = $row;
    }

    // Check for duplicates based on departure_date, departure_time, and bus_number
    foreach ($schedules as $key => $schedule) {
        foreach ($schedules as $compare_key => $compare_schedule) {
            if ($key != $compare_key && 
                $schedule['departure_date'] === $compare_schedule['departure_date'] && 
                $schedule['departure_time'] === $compare_schedule['departure_time'] && 
                $schedule['bus_number'] === $compare_schedule['bus_number']) {
                    
                // Mark both schedules as duplicates
                $duplicate_entries[$key] = true;
                $duplicate_entries[$compare_key] = true;
            }
        }
    }

    // Output the table rows
    $counter = 1;
    foreach ($schedules as $key => $row) {
        // Highlight duplicates in red
        $row_class = isset($duplicate_entries[$key]) ? "table-danger" : "";
        
        echo "<tr class='" . $row_class . "'>";
        echo "<td>" . $counter . "</td>";
        echo "<td> <label class='badge badge-info'>" . htmlspecialchars($row['destination_from']) . "</label> to <label class='badge badge-danger'>" . htmlspecialchars($row['trip_to']) . "</label></td>";
        echo "<td>" . date('F j, Y', strtotime($row['departure_date'])) . "</td>";
        echo "<td>" . date('h:i A', strtotime($row['departure_time'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['bus_number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['bus_type']) . "</td>";
        echo "<td> ₱" . htmlspecialchars($row['fare']) . "</td>"; 
        // echo "<td> <label class='badge badge-success'>" . htmlspecialchars($row['status']) . "</label></td>";
        echo "<td>
                <div class='action'>
                    <button class='btn btn-sm btn-outline-primary edit-button' data-toggle='tooltip' data-placement='top' title='Edit' data-bs-toggle='modal' data-bs-target='#schedule-modal' data-id='" . htmlspecialchars($row['schedule_id']) . "'>
                        <i class='mdi mdi-account-edit'></i>
                    </button>
                    <button class='btn btn-sm btn-outline-danger' data-toggle='tooltip' data-placement='top' title='Delete' data-bs-toggle='modal' data-bs-target='#confirm-delete' data-id='" . htmlspecialchars($row['schedule_id']) . "'>
                        <i class='mdi mdi-delete'></i>
                    </button>
                </div>
              </td>";
        echo "</tr>";
        $counter++;
    }
}

mysqli_close($conn);
?>
