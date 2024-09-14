<div class="col-12">
    <div class="fare-item">
        <div class="fare-description">Fare Amount:</div>
        <div class="fare-details">
            <div class="fare-amount"><?php echo $passenger; ?> Passenger(s) x <?php echo number_format($arrivalFare, 2); ?></div>
            <div class="fare-amount-right"><?php echo $totalArrivalFareFormatted; ?></div>
        </div>
    </div>
    <div class="fare-item">
        <div class="fare-description">Reservation Fee:</div>
        <div class="fare-details">
            <div class="fare-amount">(<?php echo number_format($reservationFeePerPassenger, 2); ?>) x <?php echo $passenger; ?> Passenger(s)</div>
            <div class="fare-amount-right"><?php echo $arrivalReservationFeeFormatted; ?></div>
        </div>
    </div>
    <div class="fare-item">
        <div class="fare-details subtotal">
            <div class="fare-amount">Subtotal</div>
            <div class="fare-amount-right"><?php echo $arrivalSubtotalFormatted; ?></div>
        </div>
    </div>
</div>