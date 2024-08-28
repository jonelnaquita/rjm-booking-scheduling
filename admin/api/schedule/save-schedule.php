<?php
include '../../../models/conn.php'; // Adjust the path to your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the data from the POST request
    $from_id = $_POST['from_id'];
    $to_id = $_POST['to_id'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $bus_id = $_POST['bus_id'];

    // Validate that all fields have values
    if (empty($from_id) || empty($to_id) || empty($departure_date) || empty($departure_time) || empty($bus_id)) {
        http_response_code(400);
        echo 'All fields are required.';
        exit();
    }

    // Prepare the SQL statement
    $query = "INSERT INTO tblschedule (destination_from, destination_to, departure_date, departure_time, bus_id) 
              VALUES (?, ?, ?, ?, ?)";

    // Initialize the prepared statement
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind the parameters to the SQL query
        mysqli_stmt_bind_param($stmt, 'iisss', $from_id, $to_id, $departure_date, $departure_time, $bus_id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo 'Schedule saved successfully.';
        } else {
            http_response_code(500);
            echo 'Error saving schedule.';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo 'Database error.';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
