<?php include '../api/fetch-departure-details.php'; ?>

<!-- Modal -->
<div class="modal fade" id="departure-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 destination">
                    <p class="destination-route"><?php echo $from_name; ?> &gt; <?php echo $to_name; ?></p>
                </div>
                <div class="col-12 details">
                    <div class="detail-item">
                        <span id="bus-type"><?php echo $bus_type; ?></span> | <span id="seaters"><?php echo $seats; ?>
                            Seaters</span> | Total Passengers: <span
                            id="total-passengers"><?php echo $passenger; ?></span>
                    </div>
                </div>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="seat-grid">
                                <!-- Driver Seat -->
                                <div class="seat driver-seat">Driver</div>
                                <div class="seat"></div>
                                <div class="seat conductor-seat">Conductor</div>
                                <div class="seat"></div>

                                <?php
                                include_once '../../models/conn.php';

                                // Assuming you have $schedule_id and $seats already set
                                // Fetch booked seat numbers and booking statuses for the current schedule
                                $query = "SELECT s.seat_number, b.status 
              FROM tblseats s
              LEFT JOIN tblbooking b ON s.passenger_id = b.passenger_id
              WHERE s.schedule_id = '$schedule_id'";
                                $result = mysqli_query($conn, $query);

                                $bookedSeats = [];
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $seatNumber = $row['seat_number'];
                                        $status = $row['status'];
                                        $bookedSeats[$seatNumber] = $status;  // Store status based on seat number
                                    }
                                }

                                echo '<div class="seat-selection">';

                                // Regular seat rows (1-40)
                                for ($i = 1; $i <= $seats - 5; $i++) {  // Loop through 1 to (seats - 5)
                                    // Start a new row every 4 seats
                                    if ($i % 4 == 1) {
                                        echo '<div class="seat-row row">';
                                    }

                                    // Determine if the current seat is booked and its status
                                    $disabled = isset($bookedSeats[$i]) ? 'disabled' : '';  // Disable the seat if booked
                                    $statusClass = '';  // Class for styling based on status
                                
                                    if (isset($bookedSeats[$i])) {
                                        if ($bookedSeats[$i] == 'Pending') {
                                            $statusClass = 'pending-seat';  // For "Pending" status (orange)
                                        } elseif ($bookedSeats[$i] == 'Confirmed') {
                                            $statusClass = 'confirmed-seat';  // For "Confirmed" status (red)
                                        }
                                    }

                                    // Generate the seat checkboxes
                                    echo '<div class="seat-pair">';
                                    echo '<label class="seat ' . $statusClass . '">';  // Add class based on status
                                    echo '<input type="checkbox" name="seat[]" value="' . $i . '" class="seat-checkbox" ' . $disabled . '>';
                                    echo '<span class="seat-number">' . $i . '</span>';
                                    echo '</label>';
                                    echo '</div>';

                                    // Insert an empty seat (gap) after seat 2, 6, 10, etc. to represent the aisle
                                    if ($i % 4 == 2) {
                                        echo '<div class="empty-seat"></div>';  // Create an empty div for the aisle
                                    }

                                    // Close the row every 4 seats
                                    if ($i % 4 == 0) {
                                        echo '</div>'; // Close the row
                                    }
                                }

                                // Last row for seats 41-45
                                echo '<div class="seat-row row last-row">';  // Single row for the last 5 seats
                                for ($i = $seats - 4; $i <= $seats; $i++) {
                                    // Determine if the seat is booked for the last row
                                    $disabled = isset($bookedSeats[$i]) ? 'disabled' : '';  // Disable the seat if booked
                                    $statusClass = '';  // Class for styling based on status
                                
                                    if (isset($bookedSeats[$i])) {
                                        if ($bookedSeats[$i] == 'Pending') {
                                            $statusClass = 'pending-seat';  // For "Pending" status (orange)
                                        } elseif ($bookedSeats[$i] == 'Confirmed') {
                                            $statusClass = 'confirmed-seat';  // For "Confirmed" status (red)
                                        }
                                    }

                                    // Generate the seat checkboxes for the last row
                                    echo '<div class="seat-pair">';
                                    echo '<label class="seat ' . $statusClass . '">';  // Add class based on status
                                    echo '<input type="checkbox" name="seat[]" value="' . $i . '" class="seat-checkbox" ' . $disabled . '>';
                                    echo '<span class="seat-number">' . $i . '</span>';
                                    echo '</label>';
                                    echo '</div>';
                                }
                                echo '</div>';  // Close the last row
                                
                                echo '</div>'; // Close the seat-selection container
                                ?>

                                <!-- JavaScript to limit the selection -->
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const maxSeats = <?php echo $passenger; ?>; // Maximum number of seats that can be selected
                                        const seatCheckboxes = document.querySelectorAll('.seat-checkbox');

                                        seatCheckboxes.forEach(checkbox => {
                                            checkbox.addEventListener('change', function () {
                                                // Count the number of selected checkboxes
                                                const selectedSeats = document.querySelectorAll('.seat-checkbox:checked').length;

                                                if (selectedSeats > maxSeats) {
                                                    // If the number of selected seats exceeds the limit, uncheck the current checkbox
                                                    this.checked = false;
                                                }
                                            });
                                        });
                                    });
                                </script>
                            </div>

                            <div class="save-button-container">
                                <button class="btn btn-primary save-departure" data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="seat-status">
                    <div class="status-item">
                        <span class="color-box priority-seat"></span>
                        <label>Priority Seats</label>
                    </div>
                    <div class="status-item">
                        <span class="color-box booked-seat"></span>
                        <label>Booked Seats</label>
                    </div>
                    <div class="status-item">
                        <span class="color-box selected-seat"></span>
                        <label>Selected Seats</label>
                    </div>
                    <div class="status-item">
                        <span class="color-box available-seat"></span>
                        <label>Available Seats</label>
                    </div>
                    <div class="status-item">
                        <span class="color-box saved-seat"></span>
                        <label>Saved Seats</label>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>