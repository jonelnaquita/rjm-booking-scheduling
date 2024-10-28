    <?php
    session_start();
    include '../../../models/conn.php'; // Adjust the path to your database connection file

    header('Content-Type: application/json'); // Set content type to JSON

    // Assuming staff ID is stored in the session
    $staff_id = $_SESSION['staff'] ?? null;

    if (!$staff_id) {
        echo json_encode(['error' => 'Staff ID is missing']);
        exit;
    }

    // Prepare the SQL query to get the bus_number based on the staff_id
    $query = "
        SELECT b.bus_number
        FROM tblstaff s
        JOIN tblbus b ON s.bus_number = b.bus_id
        WHERE s.staff_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $stmt->bind_result($bus_number);

        if ($stmt->fetch()) {
            $_SESSION['bus_number'] = $bus_number;
        } else {
            echo json_encode(['error' => 'No bus found for the given staff ID.']);
            exit;
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error in preparing the query: ' . $conn->error]);
        exit;
    }

    // Get today's date in Manila, Philippines
    date_default_timezone_set('Asia/Manila');
    $today = date('Y-m-d');

    $bus_number = $_SESSION['bus_number'];

    // Query to fetch unique schedules for today's bookings and matching bus_number
$query = "
    SELECT 
        b.book_id,
        b.passenger_id AS booking_id,
        CONCAT(p.firstname, ' ', IFNULL(p.middlename, ''), ' ', p.lastname) AS fullname,
        departure_route.destination_from AS departure_destination,
        arrival_route.destination_from AS arrival_destination,
        schedule.schedule_id AS schedule_id,
        schedule.departure_date AS schedule_date,
        schedule.departure_time AS schedule_time,
        b.price AS travel_cost,
        b.passengers AS num_passengers,
        b.status,
        GROUP_CONCAT(DISTINCT seats.seat_number ORDER BY seats.seat_number ASC) AS seat_numbers
    FROM
        tblbooking b
    JOIN
        tblpassenger p ON b.passenger_id = p.passenger_code
    LEFT JOIN
        tblschedule schedule ON b.scheduleDeparture_id = schedule.schedule_id OR b.scheduleArrival_id = schedule.schedule_id
    LEFT JOIN
        tblroutefrom departure_route ON schedule.destination_from = departure_route.from_id
    LEFT JOIN
        tblroutefrom arrival_route ON schedule.destination_to = arrival_route.from_id
    JOIN
        tblbus bus ON schedule.bus_id = bus.bus_id
    LEFT JOIN
        tblseats seats ON b.passenger_id = seats.passenger_id
    WHERE
        schedule.departure_date = ?
        AND bus.bus_number = ?
    GROUP BY
        b.book_id
    ORDER BY
        schedule.departure_date, schedule.departure_time;";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("ss", $today, $bus_number);
    $stmt->execute();
    $result = $stmt->get_result();

    $schedules = [];

    while ($row = $result->fetch_assoc()) {
        // Debugging to check values
        error_log('Departure Destination: ' . $row['departure_destination']);
        error_log('Arrival Destination: ' . $row['arrival_destination']);

        $schedule_id = $row['schedule_id'];

        if (!isset($schedules[$schedule_id])) {
            $schedules[$schedule_id] = [
                'schedule_id' => $schedule_id,
                'schedule_date' => $row['schedule_date'],
                'schedule_time' => $row['schedule_time'],
                'departure_destination' => $row['departure_destination'],
                'arrival_destination' => $row['arrival_destination'],
                'bookings' => []
            ];
        }

        $schedules[$schedule_id]['bookings'][] = [
            'book_id' => $row['booking_id'],
            'fullname' => $row['fullname'],
            'travel_cost' => $row['travel_cost'],
            'passengers' => $row['num_passengers'],
            'seat_numbers' => $row['seat_numbers'],
            'status' => $row['status']
        ];
    }

    echo json_encode(array_values($schedules));

    $stmt->close();
} else {
    echo json_encode(['error' => 'Error preparing the schedule query: ' . $conn->error]);
}
