<?php
require_once('../../../models/conn.php');

$sql = "SELECT * FROM tblbustype";
$result = $conn->query($sql);

$bus_types = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bus_types[] = $row;
    }
}

echo json_encode($bus_types);

$conn->close();
?>
