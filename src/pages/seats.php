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
        <link rel="stylesheet" href="../../assets/css/seats.css">
    </head>

<div class="container mt-5">
    <!-- Step 2 Row -->
    <div class="row step-row">
        <div class="col-12">
            <b>Step 3:</b> Choose your preferred seat
        </div>
    </div>

    <div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="booking-box p-4">
                <div class="row">
                    <div class="col-12 destination">
                        <p class="destination-route">Cubao &gt; Baguio</p>
                    </div>
                    <div class="col-12 details">
                        <div class="detail-item">
                            <strong><span id="booking-date">DEPARTURE SCHEDULE<br></span></strong>
                            <span id="booking-date">Aug 29, 2024</span> | 
                            <span id="schedule">1:00 AM</span> | 
                            Total Passengers: <span id="total-passengers">3</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button class="btn pick-seat-btn" data-toggle="modal" data-target="#exampleModal">Pick Seat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include '../modal/pick-seat.php'
?>

    <!-- Navigation Buttons -->
    <div class="row mt-4">
        <div class="col-6">
            <a href="schedules.php" class="btn btn-outline-primary btn-block">Back to Step 2</a>
        </div>
        <div class="col-6 text-right">
            <a href="summary.php" class="btn btn-primary btn-block">Next</a>
        </div>
    </div>
</div>

    <?php
        include '../components/footer.php'
    ?>
</body>
</html>