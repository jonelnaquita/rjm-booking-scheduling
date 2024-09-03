<!DOCTYPE html>
<html lang="en">
<?php
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
    <link rel="stylesheet" href="../assets/css/theme.css">

<script>

$(document).ready(function() {
    $('#table-example').DataTable({     
        "aLengthMenu": [[10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 10
        } 
    );
    });
</script>

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
                    <h3 class="tab-title">Bookings</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table-responsive-data2">
                                <table id="table-example" class="table table-data2  nowrap" style="margin-top: 20px; margin-bottom: 20px;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="au-checkbox">
                                                    <input type="checkbox">
                                                    <span class="au-checkmark"></span>
                                                </label>
                                            </th>
                                            <th>Book ID</th>
                                            <th>Full Name</th>
                                            <th>Destination</th>
                                            <th>Schedule</th>
                                            <th>Bus</th>
                                            <th>Travel Cost</th>
                                            <th>Passengers</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr-shadow">
                                            <td>
                                                <label class="au-checkbox">
                                                    <input type="checkbox">
                                                    <span class="au-checkmark"></span>
                                                </label>
                                            </td>
                                            <td>Lori Lynch</td>
                                            <td>
                                                <span class="block-email">lori@example.com</span>
                                            </td>
                                            <td class="desc">Samsung S8 Black</td>
                                            <td>2018-09-27 02:12</td>
                                            <td>
                                                <span class="status--process">Processed</span>
                                            </td>
                                            <td>$679.00</td>
                                            <td>3</td>
                                            <td>Pending</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Send">
                                                        <i class="zmdi zmdi-mail-send"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                        <i class="zmdi zmdi-more"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- END DATA TABLE -->

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

<script>
        new DataTable('#example', {
    layout: {
        topStart: {
            buttons: [
                {
                    extend: 'createState',
                    config: {
                        creationModal: true,
                        toggle: {
                            columns: {
                                search: true,
                                visible: true
                            },
                            length: true,
                            order: true,
                            paging: true,
                            search: true
                        }
                    }
                },
                'savedStates'
            ]
        }
    }
});
  </script>

</html>