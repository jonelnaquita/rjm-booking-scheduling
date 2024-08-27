<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
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
                        <div class="col-12 destination">
                            <p class="destination-route">Cubao &gt; Baguio</p>
                        </div>
                        <div class="col-12 details">
                            <div class="detail-item">
                                <strong><span id="booking-date">DEPARTURE SCHEDULE<br></span></strong>
                                <span id="booking-date">Aug 29, 2024</span> 
                                <span id="schedule">1:00 AM</span> | <br>
                                Selected Seat Number/s: <span id="seat-number">3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="fare-summary p-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="fare-item">
                                <div class="fare-description">Fare Amount:</div>
                                <div class="fare-details">
                                    <div class="fare-amount">1 Passenger x 626.00</div>
                                    <div class="fare-amount-right">626.00</div>
                                </div>
                            </div>
                            <div class="fare-item">
                                <div class="fare-description">Reservation fee:</div>
                                <div class="fare-details">
                                    <div class="fare-amount">(30.00) x 1 Passenger</div>
                                    <div class="fare-amount-right">30.00</div>
                                </div>
                            </div>
                            <div class="fare-item">
                                <div class="fare-details subtotal">
                                    <div class="fare-amount">Subtotal</div>
                                    <div class="fare-amount-right">656.00</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 total-amount">
                            <strong>Total Amount to be paid</strong>
                            <div class="fare-amount-right">656.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-md-6">
                <div class="terms-and-conditions">
                    <label>
                        <input type="checkbox" name="terms" required>
                        I have read and agree to the <a href="#">Terms and Conditions</a>
                    </label>
                </div>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <a href="payment.php" class="btn btn-primary pay-now-btn">Pay Now</a>
            </div>
        </div>





    </div>

    <?php
        include '../components/footer.php'
     ?>
</body>
</html>