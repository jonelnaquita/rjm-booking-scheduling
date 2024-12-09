<?php
require_once('../../../models/conn.php');

if (isset($_POST['bus_number'], $_POST['bustype_id'], $_POST['terminal_id'], $_POST['destination_id'], $_POST['seats'])) {
    $busNumber = $_POST['bus_number'];
    $busTypeId = $_POST['bustype_id'];
    $terminalId = $_POST['terminal_id'];
    $destinationId = $_POST['destination_id'];
    $busSeats = $_POST['seats'];

    $sql = "INSERT INTO tblbus (bus_number, bus_type, terminal_id, destination_id, seats) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $busNumber, $busTypeId, $terminalId, $destinationId, $busSeats);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error";
}
?>