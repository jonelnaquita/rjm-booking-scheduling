<?php
require_once('../../../models/conn.php');

if (isset($_POST['bus_number']) && isset($_POST['bustype_id'])) {
    $busNumber = $_POST['bus_number'];
    $busTypeId = $_POST['bustype_id'];

    // Assume database connection is already established
    $sql = "INSERT INTO tblbus (bus_number, bus_type) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $busNumber, $busTypeId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
