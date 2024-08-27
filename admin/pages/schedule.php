<!DOCTYPE html>
<html lang="en">
<?php
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
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
                    <h3 class="tab-title">Travel Schedules</h3>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Add Schedule
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                      <table id="schedule-table" class="table table-hover" style="margin-top: 20px; margin-bottom: 20px;">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Destination From</th>
                            <th>Destination To</th>
                            <th>Departure Date</th>
                            <th>Departure Time</th>
                            <th>Bus Number</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Palo</td>
                            <td>Tacloban</td>
                            <td>August 29, 2024</td>
                            <td>10:00 AM</td>
                            <td>RJM-926489</td>
                            <td>N/A</td>
                            <td>
                                <div class='table-data-feature'>
                                    <button class='item' data-toggle='tooltip' data-placement='top' title='Edit' data-id='{$row['bus_id']}'>
                                        <i class='mdi mdi-file'></i>
                                    </button>
                                    <button class='item' data-toggle='tooltip' data-placement='top' title='Delete' data-id='{$row['bus_id']}'>
                                        <i class='mdi mdi-delete'></i>
                                    </button>
                                </div>
                            </td>
                          </tr>
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
    $(document).ready(function() {
        new DataTable('#schedule-table', {
            paging: true,         // Enable pagination
            searching: true,      // Enable search box
            info: true            // Show "Showing X to Y of Z entries" information
        });
    });
</script>


</html>