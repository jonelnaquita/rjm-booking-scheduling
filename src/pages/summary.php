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
        <div class="container mt-5" style="height: 100vh;">
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
                                <?php include '../components/summary/arrival-summary.php'; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="fare-summary p-4">
                        <div class="row">
                            <?php
                            require '../../models/conn.php';  // Include your database connection script
                            
                            // Fetch the reservation fee from tbladmin
                            $query = "SELECT reservation_fee FROM tbladmin WHERE admin_id = 1"; // Adjust admin_id condition as necessary
                            $result = $conn->query($query);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $reservationFeePerPassenger = $row['reservation_fee'];
                            } else {
                                // Handle the case where the fee could not be fetched
                                $reservationFeePerPassenger = 30.00; // Default value or error handling
                            }

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
                                <?php include '../components/summary/arrival-payment.php'; ?>

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
                            I have read and agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms
                                and Conditions</a>
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

            <!-- Modal for Terms and Conditions -->
            <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </div>
                        <div class="modal-body">
                            <p><strong>1. Official Fare Ticket</strong></p>
                            <p>This reservation ticket serves as an official fare ticket for all intended purposes.</p>

                            <p><strong>2. Check-In Time</strong></p>
                            <p>Passengers must check in at least 20 minutes prior to the scheduled departure time.
                                Failure to check in within this period will result in the cancellation of the
                                reservation, and the seat may be reassigned to stand-by passengers.</p>

                            <p><strong>3. Ticket Validity</strong></p>
                            <p>This ticket is only valid on the specified date or on a rebooked date.</p>

                            <p><strong>4. Non-Refundable Policy</strong></p>
                            <p>This reservation ticket is non-refundable except in cases of force majeure or
                                cancellations made by the company. In such cases, passengers may rebook the ticket
                                without additional fees within fifteen (15) calendar days of the original trip date.</p>

                            <p>Passengers may also rebook at any time before the departure date or within fifteen (15)
                                calendar days after the trip date. If not rebooked within this period, the fare will be
                                forfeited to the company.</p>

                            <p><strong>5. Cancellation and Schedule Changes</strong></p>
                            <p>RJM Transport Corporation reserves the right to cancel or reschedule trips, including
                                departure times or dates, without prior notice.</p>

                            <p><strong>6. Liability for Loss/Damage of Personal Belongings</strong></p>
                            <p>RJM Transport Corporation is not liable for loss or damage of items, luggage, or personal
                                belongings unless these items are declared and presented to the shipping clerk or
                                conductor, and the passenger follows the provided instructions regarding their
                                safekeeping.</p>

                            <p><strong>7. Lost Tickets</strong></p>
                            <p>Lost passenger tickets will not be refunded or replaced under any circumstance, and the
                                passenger will need to purchase a new ticket to travel.</p>

                            <p><strong>8. Unauthorized Alterations</strong></p>
                            <p>Any unauthorized erasure or alteration of the information on this ticket will render it
                                void.</p>

                            <!-- Add more terms content as needed -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const termsCheckbox = document.getElementById('termsCheckbox');
                    const payNowBtn = document.getElementById('payNowBtn');
                    const termsError = document.getElementById('termsError');

                    payNowBtn.addEventListener('click', function (e) {
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

                    termsCheckbox.addEventListener('change', function () {
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