<!DOCTYPE html>
<html lang="en">
<?php
include '../api/session.php';
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
</head>
<body>

    <div class="container-scroller">
        <!--Include Navigation Bar-->
        <?php include '../components/navbar.php'; ?>
        <!--End-->

        <div class="container-fluid page-body-wrapper">
            <!-- Include Sidebar-->
            <?php
                include '../components/sidebar.php';
            ?>


            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Tab Indicator or Title -->
                    <h3 class="tab-title">Cancelled Bookings</h3>
                    <div class="table-responsive ">
                            <table id="table-example" class="table table-data2 nowrap dt-responsive w-100" style="margin-top: 20px; margin-bottom: 20px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Book ID</th>
                                        <th>Full Name</th>
                                        <th>Destination</th>
                                        <th>Schedule</th>
                                        <th>Bus</th>
                                        <th>Travel Cost</th>
                                        <th>Passengers</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include '../api/booking/fetch-booking-cancelled.php';
                                    ?>
                                </tbody>
                            </table>
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

<script>
    $(document).ready(function(){
        var table = $('#table-example').DataTable({
            "aLengthMenu": [[10, 25, -1], [10, 25, 50, "All"]],
            "iDisplayLength": 10
        });
    })
</script>



</html>