<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
    include '../api/store-schedule.php';
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
            <!--Show Departure Schedule Card-->
            <?php 

                if ($direction === 'Round-Trip') {
                    // Include both components if the direction is 'Round-Trip'
                    include '../components/seats/departure-schedule.php';
                    include '../components/seats/arrival-schedule.php';
                } else {
                    // Include only the departure-schedule component if the direction is not 'Round-Trip'
                    include '../components/seats/departure-schedule.php';
                }
                ?>

        </div>
    </div>

<?php
    include '../modal/pick-seat-arrival.php';
    include '../modal/pick-seat-departure.php';
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