<?php
// Include database connection
include '../../models/conn.php';

// SQL query to fetch passenger_id and contact_number from tblreschedule
$sql = "SELECT * FROM tblreschedule WHERE status = ''";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    $counter = 1;
    
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $counter . "</td>
                <td>" . $row['passenger_id'] . "</td>
                <td>" . $row['contact_number'] . "</td>
                <td>
                <div class='table-data-feature'>
                        <button type='button'
                            class='btn btn-primary btn-accept btn-rounded btn-fw'
                            data-bs-toggle='modal'
                            data-bs-target='#reschedule-status'
                            data-book-id='{$row['reschedule_id']}' 
                            style='margin-right: 5px;'>Done
                        </button>
                    </div>
                </td>
              </tr>";
        $counter++;
    }
}

// Close the database connection
$conn->close();
?>
