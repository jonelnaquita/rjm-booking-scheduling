<?php include '../api/fetch-departure-details.php';?>

<!-- Modal -->
<div class="modal fade" id="arrival-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <span id="bus-type"><?php echo $bus_type; ?></span> | <span id="seaters"><?php echo $seats; ?> Seaters</span> | Total Passengers: <span id="total-passengers"><?php echo $passenger; ?></span>
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

                            echo '<div class="seat-selection">';

                            for ($i = 1; $i <= $seats; $i++) {
                                // Start a new row every 4 seats
                                if ($i % 4 == 1) {
                                    echo '<div class="seat-row row">';
                                }

                                // Generate the seat checkboxes
                                echo '<div class="seat-pair">';
                                echo '<label class="seat">';
                                echo '<input type="checkbox" name="seat[]" value="' . $i . '" class="seat-checkbox">';
                                echo '<span class="seat-number">' . $i . '</span>';
                                echo '</label>';
                                echo '</div>';

                                // Close the row after every 4 seats or at the last seat
                                if ($i % 4 == 0 || $i == $seats) {
                                    echo '</div>'; // Close the row
                                }
                            }

                            echo '</div>'; // Close the seat-selection container
                            ?>

                            <!-- JavaScript to limit the selection -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const maxSeats = <?php echo $passenger; ?>; // Maximum number of seats that can be selected
                                    const seatCheckboxes = document.querySelectorAll('.seat-checkbox');

                                    seatCheckboxes.forEach(checkbox => {
                                        checkbox.addEventListener('change', function() {
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

                        <!-- Row 11 (Last Row)
                        <div class="seat-row last-row">
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="45">
                                    <span class="seat-number">41</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="46">
                                    <span class="seat-number">42</span>
                                </label>
                            </div>
                            <div class="seat-pair">
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="47">
                                    <span class="seat-number">43</span>
                                </label>
                                <label class="seat">
                                    <input type="checkbox" name="seat" value="48">
                                    <span class="seat-number">44</span>
                                </label>
                            </div>
                            <label class="seat">
                                <input type="checkbox" name="seat" value="49">
                                <span class="seat-number">45</span>
                            </label>
                        </div> -->
                    </div>
                    <div class="save-button-container">
                        <button class="btn btn-primary">Save</button>
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