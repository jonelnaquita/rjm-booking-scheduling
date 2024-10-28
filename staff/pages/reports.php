<!DOCTYPE html>
<html lang="en">
<?php
    include '../api/session.php';
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Optional CSS for Material Design-like styling -->
    <style>
        .btn-material {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .btn-rounded {
            border-radius: 30px;
        }

        /* Make DataTable more clean */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 30px;
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            outline: none;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #2196f3;
            box-shadow: none;
        }

        /* Add some space for the buttons */
        .dataTables_wrapper .dt-buttons {
            margin-top: 10px;
        }
    </style>


        <!-- DataTables Buttons Extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>


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
                    <h3 class="tab-title">Reports</h3>

                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="passenger-tab" data-bs-toggle="tab" href="#passenger" role="tab" aria-controls="passenger" aria-selected="true">Passenger</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="booking-tab" data-bs-toggle="tab" href="#booking" role="tab" aria-controls="booking" aria-selected="false">Booking</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="revenue-tab" data-bs-toggle="tab" href="#revenue" role="tab" aria-controls="revenue" aria-selected="false">Revenue</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="passenger" role="tabpanel" aria-labelledby="passenger-tab">
                                    <div class="media">
                                        <?php include '../components/reports/passenger-tab.php' ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="booking" role="tabpanel" aria-labelledby="booking-tab">
                                       <?php include '../components/reports/booking-tab.php' ?>
                                </div>
                                <div class="tab-pane fade" id="revenue" role="tabpanel" aria-labelledby="revenue-tab">
                                    <?php include '../components/reports/revenue-tab.php' ?>
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
</body>






</html>