<?php
require '../../models/conn.php';

// Fetch the destination names
$query = "SELECT 
            (SELECT destination_from FROM tblroutefrom WHERE from_id = '$destination_from') as from_name, 
            (SELECT destination_from FROM tblroutefrom WHERE from_id = '$destination_to') as to_name";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $from_name = $row['from_name'];
    $to_name = $row['to_name'];
} else {
    $from_name = "Unknown";
    $to_name = "Unknown";
}
?>
