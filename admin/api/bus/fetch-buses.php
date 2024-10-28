<?php
require_once('../../models/conn.php');

$sql = "SELECT 
            tblbus.bus_id,
            tblbus.bus_number,
            tblbus.status,
            tblbus.seats,
            tblbustype.bus_type
        FROM 
            tblbus
        LEFT JOIN 
            tblbustype 
        ON 
            tblbus.bus_type = tblbustype.bustype_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $counter = 1; // Initialize counter for consecutive numbers
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='tr-shadow'>
                <td>{$counter}</td>
                <td>{$row['bus_number']}</td>
                <td class='desc'>{$row['bus_type']}</td>
                <td class='desc'>{$row['seats']}</td>
                <td>
                    <span class='block-email'>{$row['status']}</span>
                </td>
                <td>
                    <div class='action'>
                        <button class='btn btn-sm btn-outline-primary edit-button' data-toggle='tooltip' data-placement='top' title='Edit' data-bs-toggle='modal' data-bs-target='#update-bus' data-id='" . htmlspecialchars($row['bus_id']) . "'>
                            <i class='mdi mdi-account-edit'></i>
                        </button>
                        <button class='btn btn-sm btn-outline-primary delete-button' data-toggle='tooltip' data-placement='top' title='Delete' 
                                data-bs-toggle='modal' data-bs-target='#confirm-delete' data-id='" . htmlspecialchars($row['bus_id']) . "'>
                            <i class='mdi mdi-delete'></i>
                        </button>

                    </div>
                </td>
            </tr>";
        $counter++; // Increment counter for next row
    }
} else {
    echo "<tr><td colspan='6'>No buses found.</td></tr>";
}
?>