
<div class="destination-summary" style="margin-top: 30px;">
    <hr>
    <div class="col-12 destination">
        <p class="destination-route"><?php echo $to_name; ?> &gt; <?php echo $from_name; ?></p>
    </div>
    <div class="col-12 details">
        <div class="detail-item">
            <strong><span id="booking-date">ARRIVAL SCHEDULE<br></span></strong>
            <span id="booking-date">
                <?php 
                    // Format the arrival date to a readable format (e.g., Aug 29, 2024)
                    echo date('M j, Y', strtotime($arrival_date)); 
                ?>
            </span> | 
            <span id="schedule">
                <?php 
                    // Format the arrival time to a 12-hour format with AM/PM
                    echo date('g:i A', strtotime($arrival_time)); 
                ?>
            </span> | 
            Total Passengers: <span id="total-passengers"><?php echo $passenger; ?></span>
            <?php
                if (isset($_SESSION['arrival_seats'])) {
                    $arrivalSeats = $_SESSION['arrival_seats'];
                    $seatNumbers = implode(', ', array_map('htmlspecialchars', $arrivalSeats));

                    echo 'Selected Seat Number/s: <span id="seat-number">' . $seatNumbers . '</span>';
                } else {
                    echo 'Selected Seat Number/s: <span id="seat-number">None</span>';
                }
            ?>
        </div>
    </div>
</div>
