<?php
require_once('../../models/conn.php');

$sql = "SELECT 
            tblbus.bus_id,
            tblbus.bus_number,
            tblbus.status,
            tblbustype.bus_type
        FROM 
            tblbus
        JOIN 
            tblbustype 
        ON 
            tblbus.bus_type = tblbustype.bustype_id";

$result = $conn->query($sql);
?>