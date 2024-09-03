<div class="col-12">
    <div class="booking-box p-4">
        <div class="row">
            <?php include '../api/fetch-destination.php'?>
            <div class="col-12 destination">
                <p class="destination-route"><?php echo $from_name; ?> &gt; <?php echo $to_name; ?></p>
            </div>
            <?php include '../api/fetch-departure-details.php';?>
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
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <button class="btn pick-seat-btn" data-toggle="modal" data-target="#departure-modal">Pick Seat</button>
            </div>
        </div>
    </div>
</div>