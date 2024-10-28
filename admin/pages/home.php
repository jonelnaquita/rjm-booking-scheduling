<?php
    include '../api/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
?>
<body>

    <div class="container-scroller">
        <?php include '../components/navbar.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <?php include '../components/sidebar.php';?>

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h3 class="font-weight-bold">Welcome Admin</h3>
                                <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                                </div>
                            </div>

                            
                            <?php
                                include 'components/dashboard/booking-summary.php';
                                include 'components/dashboard/revenue-chart.php';
                                include 'components/dashboard/bus-chart.php'
                            ?>


                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                <div class="card position-relative">
                                    <div class="card-body">
                                    <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="row">
                                            <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                <div class="ml-xl-4 mt-3">
                                                <p class="card-title">Booking Details</p>
                                                <p class="mb-2 mb-xl-0 card-description">This shows the booking details for each terminal, highlighting the total number of bookings per location. It also provides a breakdown of booking statuses, including the number of pending, confirmed, and canceled bookings, giving a clear view of booking trends and operational efficiency across terminals.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-xl-9">
                                                <div class="row">
                                                <div class="col-md-6 border-right">
                                                    <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                        <?php include 'components/dashboard/booking-terminal-chart.php'?>
                                                    </div>
                                                </div>

                                                <?php include 'components/dashboard/booking-status-chart.php'?>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!--Include Footer -->
            <?php
                include '../components/footer.php';
            ?>

            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</body>





</html>