<?php
// Include your database connection file
require '../../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $staff_id = $_POST['staff_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $terminal = $_POST['terminal'];
    $mobile_number = $_POST['mobile_number'];
    $bus_number = $terminal == 'Terminal Staff' ? 0 : $_POST['bus_number'];

    // Capture rest_day (comma-separated values)
    $rest_days = isset($_POST['rest_day']) && is_array($_POST['rest_day']) ? implode(',', $_POST['rest_day']) : '';

    // Prepare SQL query to update staff details
    $update_query = "
        UPDATE tblstaff 
        SET firstname = ?, lastname = ?, mobile_number = ?, role = ?, terminal = ?, bus_number = ?, rest_day = ?
        WHERE staff_id = ?
    ";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('sssssssi', $firstname, $lastname, $mobile_number, $role, $terminal, $bus_number, $rest_days, $staff_id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>