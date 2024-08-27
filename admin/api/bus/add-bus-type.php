<?php
require_once('../../../models/conn.php');

if (isset($_POST['bus_type']) && isset($_POST['description'])) {
    $busType = $_POST['bus_type'];
    $description = $_POST['description'];

    // Assume that database connection is already established
    $sql = "INSERT INTO tblbustype (bus_type, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $busType, $description);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
