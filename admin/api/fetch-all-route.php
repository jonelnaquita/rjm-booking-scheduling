<?php
    // Fetch all route from data along with province names
    $sql = "
        SELECT 
            rfrom.from_id,
            rfrom.destination_from AS from_name,
            prov.province AS province_name 
        FROM tblroutefrom rfrom
        LEFT JOIN tblprovince prov ON prov.province_id = rfrom.province
    ";
    $result = $conn->query($sql);

    // Initialize an array to hold destinations by from_id
    $destinationsByFromId = [];

    // Fetch matching destinations from tblrouteto
    $destinationsSql = "
        SELECT
            rto.to_id,
            rto.from_id, 
            rfrom.destination_from AS from_name
        FROM tblroutefrom rfrom
        LEFT JOIN tblrouteto rto ON rfrom.from_id = rto.destination_to
    ";

    $destinationsResult = $conn->query($destinationsSql);

    // Populate destinations by from_id
    while ($row = $destinationsResult->fetch_assoc()) {
        $from_id = $row['from_id'];
        $from_name = $row['from_name'];
        if (!isset($destinationsByFromId[$from_id])) {
            $destinationsByFromId[$from_id] = [];
        }
        $destinationsByFromId[$from_id][] = $from_name;
    }
?>