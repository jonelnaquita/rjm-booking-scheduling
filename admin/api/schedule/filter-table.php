<?php
include '../../../models/conn.php'; // Adjust the path to your database connection file

$departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
$departure_time = isset($_POST['departure_time']) ? $_POST['departure_time'] : '';

// Construct SQL query with filters
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
            trf.destination_from AS trip_to,
            s.fare
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
        WHERE 1=1
        
";

// Add filters to query
if (!empty($departure_date)) {
    $query .= " AND s.departure_date = '" . mysqli_real_escape_string($conn, $departure_date) . "'";
}
if (!empty($departure_time)) {
    $query .= " AND s.departure_time = '" . mysqli_real_escape_string($conn, $departure_time) . "'";
}

$query .= " ORDER BY s.schedule_id ASC";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $counter = 1;
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
        echo "<td> <label class='badge badge-info'>". htmlspecialchars($row['destination_from']) ."</label> to <label class='badge badge-danger'>". htmlspecialchars($row['trip_to']) ."</label></td>";
        echo "<td>" . date('F j, Y', strtotime($row['departure_date'])) . "</td>";
        echo "<td>" . date('h:i A', strtotime($row['departure_time'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['bus_number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['bus_type']) . "</td>";
        echo "<td> ₱" . htmlspecialchars($row['fare']) . "</td>"; 
        // echo "<td> <label class='badge badge-success'>". htmlspecialchars($row['status']) ."</label></td>";
        echo "<td>
                <div class='table-data-feature'>
                    <button class='btn btn-sm btn-outline-primary edit-button mr-2' data-toggle='tooltip' data-placement='top' title='Edit' data-bs-toggle='modal' data-bs-target='#schedule-modal' data-id='" . htmlspecialchars($row['schedule_id']) . "'>
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
} else {
    echo "<tr><td colspan='9'>No schedules found.</td></tr>";
}

mysqli_close($conn);
?>
