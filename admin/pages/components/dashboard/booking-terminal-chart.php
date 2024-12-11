<?php
include '../../models/conn.php'; // Include your database connection

// SQL query to fetch bookings count per terminal and per destination
$query = "
    SELECT 
        rf.destination_from AS terminal_name, 
        COUNT(CASE WHEN b.scheduleDeparture_id = s.schedule_id THEN b.book_id END) AS departure_count,
        COUNT(CASE WHEN b.scheduleArrival_id = s.schedule_id THEN b.book_id END) AS arrival_count
    FROM 
        tblbooking b
    LEFT JOIN 
        tblschedule s ON b.scheduleDeparture_id = s.schedule_id OR b.scheduleArrival_id = s.schedule_id
    LEFT JOIN 
        tblroutefrom rf ON s.destination_from = rf.from_id
    WHERE status = 'Confirmed'
    GROUP BY 
        rf.destination_from;
";

$result = $conn->query($query);

$totalDepartureBookings = 0;
$totalArrivalBookings = 0;
$terminals = [];
$departureCounts = [];
$arrivalCounts = [];

// Calculate totals and prepare terminal data
while ($row = $result->fetch_assoc()) {
    if ($row['departure_count'] > 0 || $row['arrival_count'] > 0) {
        $terminals[] = $row['terminal_name'];
        $departureCounts[] = $row['departure_count'];
        $arrivalCounts[] = $row['arrival_count'];
        $totalDepartureBookings += $row['departure_count'];
        $totalArrivalBookings += $row['arrival_count'];
    }
}

// Function to calculate the width percentage
function calculatePercentage($count, $total)
{
    return ($total > 0) ? ($count / $total) * 100 : 0;
}

// Close the connection
$conn->close();
?>

<?php if ($totalDepartureBookings > 0): ?>
    <h5>Bookings per Terminal</h5>
    <table class="table table-borderless report-table">
        <tbody>
            <?php foreach ($terminals as $index => $terminal):
                $count = $departureCounts[$index];
                if ($count > 0):
                    $percentage = calculatePercentage($count, $totalDepartureBookings);
                    // Define colors for progress bar
                    $progressBarColors = ['bg-primary', 'bg-warning', 'bg-danger', 'bg-info', 'bg-success'];
                    $color = $progressBarColors[$index % count($progressBarColors)];
                    ?>
                    <tr>
                        <td class="text-muted"><?= htmlspecialchars($terminal) ?></td>
                        <td class="w-100 px-0">
                            <div class="progress progress-md mx-4">
                                <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= round($percentage) ?>%"
                                    aria-valuenow="<?= round($percentage) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>
                            <h5 class="font-weight-bold mb-0"><?= htmlspecialchars($count) ?></h5>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if ($totalArrivalBookings > 0): ?>
    <h5>Bookings per Destination</h5>
    <table class="table table-borderless report-table">
        <tbody>
            <?php foreach ($terminals as $index => $terminal):
                $count = $arrivalCounts[$index];
                if ($count > 0):
                    $percentage = calculatePercentage($count, $totalArrivalBookings);
                    // Define colors for progress bar
                    $progressBarColors = ['bg-primary', 'bg-warning', 'bg-danger', 'bg-info', 'bg-success'];
                    $color = $progressBarColors[$index % count($progressBarColors)];
                    ?>
                    <tr>
                        <td class="text-muted"><?= htmlspecialchars($terminal) ?></td>
                        <td class="w-100 px-0">
                            <div class="progress progress-md mx-4">
                                <div class="progress-bar <?= $color ?>" role="progressbar" style="width: <?= round($percentage) ?>%"
                                    aria-valuenow="<?= round($percentage) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>
                            <h5 class="font-weight-bold mb-0"><?= htmlspecialchars($count) ?></h5>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>