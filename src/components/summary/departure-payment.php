<div class="col-12">
    <div class="fare-item">
        <div class="fare-description">Fare Amount:</div>
        <div class="fare-details">
            <div class="fare-amount"><?php echo $passenger; ?> Passenger(s) x <?php echo number_format($departureFare, 2); ?></div>
            <div class="fare-amount-right"><?php echo number_format($totalDepartureFare, 2); ?></div>
        </div>
    </div>
    <div class="fare-item">
        <div class="fare-description">Reservation Fee:</div>
        <div class="fare-details">
            <div class="fare-amount">(<?php echo number_format($reservationFeePerPassenger, 2); ?>) x <?php echo $passenger; ?> Passenger(s)</div>
            <div class="fare-amount-right"><?php echo $departureReservationFeeFormatted; ?></div>
        </div>
    </div>
    <div class="fare-item">
        <div class="fare-details subtotal">
            <div class="fare-amount">Subtotal</div>
            <div class="fare-amount-right"><?php echo $departureSubtotalFormatted; ?></div>
        </div>
    </div>
</div>