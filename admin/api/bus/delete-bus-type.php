// delete_bus_type.php
<?php
require_once('../../../models/conn.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tblbustype WHERE bustype_id = $id";
    $conn->query($sql);
}

$conn->close();
?>
