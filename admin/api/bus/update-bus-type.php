<?php
require_once('../../../models/conn.php');

if (isset($_POST['bustype_id']) && isset($_POST['bus_type']) && isset($_POST['description'])) {
    $busTypeId = $_POST['bustype_id'];
    $busType = $_POST['bus_type'];
    $description = $_POST['description'];

    // Assume that database connection is already established
    $sql = "UPDATE tblbustype SET bus_type = ?, description = ? WHERE bustype_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $busType, $description, $busTypeId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
