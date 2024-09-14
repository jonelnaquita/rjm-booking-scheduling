<div class="destination-summary">
    <div class="col-12 destination">
        <p class="destination-route"><?php echo $from_name; ?> &gt; <?php echo $to_name; ?></p>
    </div>
    <div class="col-12 details">
        <div class="detail-item">
            <strong><span id="booking-date">DEPARTURE SCHEDULE<br></span></strong>
            <span id="booking-date">
                <?php 
                    // Format the departure date to a readable format (e.g., Aug 29, 2024)
                    echo date('M j, Y', strtotime($departure_date)); 
                ?>
            </span> | 
            <span id="schedule">
                <?php 
                    // Format the departure time to a 12-hour format with AM/PM
                    echo date('g:i A', strtotime($departure_time)); 
                ?>
            </span> | 
            Total Passengers: <span id="total-passengers"><?php echo $passenger; ?></span>
            <?php
                if (isset($_SESSION['departure_seats'])) {
                    $departureSeats = $_SESSION['departure_seats'];
                    $seatNumbers = implode(', ', array_map('htmlspecialchars', $departureSeats));

                    echo 'Selected Seat Number/s: <span id="seat-number">' . $seatNumbers . '</span>';
                } else {

                    echo 'Selected Seat Number/s: <span id="seat-number">None</span>';
                }
                ?>
        </div>
    </div>
</div>