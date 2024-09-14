<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
    include '../api/store-schedule.php';
    include '../api/fetch-passenger-details.php';
    include '../api/fetch-departure-seats.php';
    include '../api/fetch-arrival-seats.php';
    include '../api/fetch-destination.php';
    include '../api/fetch-departure-details.php';
    include '../api/fetch-arrival-details.php';
?>
<body>
    <?php
        include '../components/nav.php';
    ?>

    <head>
        <link rel="stylesheet" href="../../assets/css/summary.css">
    </head>

    <div>
    <div class="container mt-5">
        <!-- Step 1 Row -->
        <div class="row step-row">
            <div class="col-12 ">
                <b>Step 4:</b> Summary of Charges
            </div>
        </div>

        <div class="row fare-summary2">
            <div class="col-12 col-md-6">
                <div class="booking-box p-4">
                    <div class="row">
                        <?php
                            include '../components/summary/departure-summary.php';
                            if ($direction === 'Round-Trip'): ?>
                                <?php include '../components/summary/arrival-summary.php';?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="fare-summary p-4">
                    <div class="row">
                        <?php
                            $reservationFeePerPassenger = 30.00;

                            // Calculate amounts for departure
                            $totalDepartureFare = $departureFare * $passenger;
                            $departureReservationFee = $reservationFeePerPassenger * $passenger;
                            $departureSubtotal = $totalDepartureFare + $departureReservationFee;

                            // Initialize arrival variables
                            $totalArrivalFare = 0;
                            $arrivalReservationFee = 0;
                            $arrivalSubtotal = 0;

                            // Calculate amounts for arrival if Round-Trip
                            if ($direction === 'Round-Trip') {
                                $totalArrivalFare = $arrivalFare * $passenger;
                                $arrivalReservationFee = $reservationFeePerPassenger * $passenger;
                                $arrivalSubtotal = $totalArrivalFare + $arrivalReservationFee;
                            }

                            // Calculate total amounts
                            $totalFare = $totalDepartureFare + $totalArrivalFare;
                            $totalReservationFee = $departureReservationFee + $arrivalReservationFee;
                            $totalAmount = $departureSubtotal + $arrivalSubtotal;

                            // Format values for display
                            $totalDepartureFareFormatted = number_format($totalDepartureFare, 2);
                            $departureReservationFeeFormatted = number_format($departureReservationFee, 2);
                            $departureSubtotalFormatted = number_format($departureSubtotal, 2);

                            $totalArrivalFareFormatted = number_format($totalArrivalFare, 2);
                            $arrivalReservationFeeFormatted = number_format($arrivalReservationFee, 2);
                            $arrivalSubtotalFormatted = number_format($arrivalSubtotal, 2);

                            $totalFareFormatted = number_format($totalFare, 2);
                            $totalReservationFeeFormatted = number_format($totalReservationFee, 2);
                            $totalAmountFormatted = number_format($totalAmount, 2);

                            // Store $totalAmount in session
                            $_SESSION['totalAmount'] = $totalAmount;
                        ?>

                        <?php
                            include '../components/summary/departure-payment.php';

                            if ($direction === 'Round-Trip'): ?>
                            <?php include '../components/summary/arrival-payment.php';?>
                            
                        <?php endif; ?>

                        <div class="col-12 total-amount">
                            <strong>Total Amount to be Paid</strong>
                            <div class="fare-amount-right"><?php echo $totalAmountFormatted; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-md-6">
                <div class="terms-and-conditions">
                    <label>
                        <input type="checkbox" id="termsCheckbox" name="terms" required>
                        I have read and agree to the <a href="#">Terms and Conditions</a>
                    </label>
                </div>
                <div id="termsError" class="error-message" style="font-size: 12px; color: red; display: none;">
                    Please agree to the Terms and Conditions before proceeding.
                </div>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <button id="payNowBtn" class="btn btn-primary pay-now-btn">Pay Now</button>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const termsCheckbox = document.getElementById('termsCheckbox');
            const payNowBtn = document.getElementById('payNowBtn');
            const termsError = document.getElementById('termsError');

            payNowBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default action

                if (!termsCheckbox.checked) {
                    termsError.style.display = 'block';
                } else {
                    termsError.style.display = 'none';
                    
                    // Use AJAX to update the session before redirecting
                    fetch('../api/store-total-amount.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            totalAmount: <?php echo json_encode($totalAmount); ?>
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = 'payment.php';
                        } else {
                            console.error('Failed to update session');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                }
            });

            termsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    termsError.style.display = 'none';
                }
            });
        });
        </script>

        <?php
            include '../components/footer.php'
        ?>
    </body>
    </html>