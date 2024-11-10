<?php
// Include your database connection file
require '../../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $terminal = $_POST['terminal'];
    $mobile_number = $_POST['mobile_number'];
    if ($terminal == 'Terminal Staff') {
        $bus_number = 0;
    } else {
        $bus_number = $_POST['bus_number'];
    }

    // Prepare SQL query to update staff details
    $update_query = "
        UPDATE tblstaff 
        SET firstname = ?, lastname = ?, mobile_number = ?, role = ?, terminal = ?, bus_number = ? 
        WHERE staff_id = ?
    ";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssssssi', $firstname, $lastname, $mobile_number, $role, $terminal, $bus_number, $staff_id);

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