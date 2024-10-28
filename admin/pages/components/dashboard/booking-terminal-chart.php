<?php
include '../../models/conn.php'; // Include your database connection

// SQL query to fetch bookings count per terminal
$query = "
    SELECT 
        rf.destination_from, 
        COUNT(b.book_id) AS booking_count
    FROM 
        tblbooking b
    JOIN 
        tblschedule s ON b.scheduleDeparture_id = s.schedule_id OR b.scheduleArrival_id = s.schedule_id
    JOIN 
        tblroutefrom rf ON s.destination_from = rf.from_id
    WHERE status = 'Confirmed'
    GROUP BY 
        rf.destination_from;
";

$result = $conn->query($query);

$totalBookings = 0;
$terminals = [];
$bookingCounts = [];

// Calculate total bookings and prepare terminal data
while ($row = $result->fetch_assoc()) {
    $terminals[] = $row['destination_from'];
    $bookingCounts[] = $row['booking_count'];
    $totalBookings += $row['booking_count'];
}

// Function to calculate the width percentage
function calculatePercentage($count, $total) {
    return ($total > 0) ? ($count / $total) * 100 : 0;
}

// Close the connection
$conn->close();
?>

<table class="table table-borderless report-table">
    <tbody>
    <?php foreach ($terminals as $index => $terminal): 
        $count = $bookingCounts[$index];
        $percentage = calculatePercentage($count, $totalBookings);
        // Define colors for progress bar (can be customized)
        $progressBarColors = ['bg-primary', 'bg-warning', 'bg-danger', 'bg-info', 'bg-success'];
        $color = $progressBarColors[$index % count($progressBarColors)];
    ?>
        <tr>
            <td class="text-muted"><?= htmlspecialchars($terminal) ?></td>
            <td class="w-100 px-0">
                <div class="progress progress-md mx-4">
                    <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= round($percentage) ?>%" aria-valuenow="<?= round($percentage) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </td>
            <td>
                <h5 class="font-weight-bold mb-0"><?= htmlspecialchars($count) ?></h5>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
