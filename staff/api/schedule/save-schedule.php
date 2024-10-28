<?php
include '../../../models/conn.php'; // Adjust to your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from_id = $_POST['from_id'];
    $to_id = $_POST['to_id'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $bus_id = $_POST['bus_id'];
    $fare = $_POST['fare'];

    // Check for required fields
    if (empty($from_id) || empty($to_id) || empty($departure_date) || empty($departure_time) || empty($bus_id)) {
        http_response_code(400);
        echo 'All fields are required.';
        exit();
    }

    // Check for duplicate schedule
    $check_query = "SELECT COUNT(*) FROM tblschedule 
                    WHERE destination_from = ? 
                    AND destination_to = ? 
                    AND departure_date = ? 
                    AND departure_time = ? 
                    AND bus_id = ?";

    if ($stmt_check = mysqli_prepare($conn, $check_query)) {
        mysqli_stmt_bind_param($stmt_check, 'iissi', $from_id, $to_id, $departure_date, $departure_time, $bus_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $count);
        mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);

        if ($count > 0) {
            http_response_code(409);
            echo 'Schedule already exists.';
            exit();
        }
    } else {
        http_response_code(500);
        echo 'Database error during schedule check.';
        exit();
    }

    // Insert new schedule
    $insert_query = "INSERT INTO tblschedule (destination_from, destination_to, departure_date, departure_time, fare, bus_id) 
                     VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $insert_query)) {
        mysqli_stmt_bind_param($stmt, 'iissss', $from_id, $to_id, $departure_date, $departure_time, $fare, $bus_id);

        if (mysqli_stmt_execute($stmt)) {
            echo 'Schedule saved successfully.';
        } else {
            http_response_code(500);
            echo 'Error saving schedule.';
        }

        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo 'Database error during insert.';
    }

    mysqli_close($conn);
}
?>
