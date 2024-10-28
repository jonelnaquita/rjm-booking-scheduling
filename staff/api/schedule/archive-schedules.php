<?php
require '../../../models/conn.php';

function archivePastSchedules($conn) {
    $today = date('Y-m-d'); // Get today's date in 'YYYY-MM-DD' format

    // Update sched_status to 'Archived' where departure_date is today
    $query = "UPDATE tblschedule SET sched_status = 'Archived' WHERE departure_date <= '$today'";

    if (mysqli_query($conn, $query)) {
        return ['success' => true, 'message' => 'Schedules updated successfully.'];
    } else {
        return ['success' => false, 'message' => 'Error updating schedules: ' . mysqli_error($conn)];
    }
}

// If this script is being accessed via AJAX, execute the function
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = archivePastSchedules($conn);
    echo json_encode($response);
}
?>
