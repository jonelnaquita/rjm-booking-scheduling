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

                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h3 class="font-weight-bold">Welcome Admin</h3>
                                <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span class="text-primary">3
                                    unread alerts!</span></h6>
                                </div>
                                <div class="col-12 col-xl-4">
                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                        <a class="dropdown-item" href="#">January - March</a>
                                        <a class="dropdown-item" href="#">March - June</a>
                                        <a class="dropdown-item" href="#">June - August</a>
                                        <a class="dropdown-item" href="#">August - November</a>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>


                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12 grid-margin transparent">
                                <div class="row">
                                    <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                        <p class="mb-4">Today’s Bookings</p>
                                        <p class="fs-30 mb-2">4006</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                        <p class="mb-4">Total Bookings</p>
                                        <p class="fs-30 mb-2">61344</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-light-blue">
                                        <div class="card-body">
                                        <p class="mb-4">Number of Passengers</p>
                                        <p class="fs-30 mb-2">34040</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-light-danger">
                                        <div class="card-body">
                                        <p class="mb-4">Total Revenue</p>
                                        <p class="fs-30 mb-2">47033</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                        <p class="card-title">Booking Details</p>
                                        <p class="font-weight-500">Description</p>
                                        <div class="d-flex flex-wrap mb-5">
                                            <div class="me-5 mt-3">
                                            <p class="text-muted">Order value</p>
                                            <h3 class="text-primary fs-30 font-weight-medium">12.3k</h3>
                                            </div>
                                            <div class="me-5 mt-3">
                                            <p class="text-muted">Orders</p>
                                            <h3 class="text-primary fs-30 font-weight-medium">14k</h3>
                                            </div>
                                            <div class="me-5 mt-3">
                                            <p class="text-muted">Users</p>
                                            <h3 class="text-primary fs-30 font-weight-medium">71.56%</h3>
                                            </div>
                                            <div class="mt-3">
                                            <p class="text-muted">Downloads</p>
                                            <h3 class="text-primary fs-30 font-weight-medium">34040</h3>
                                            </div>
                                        </div>
                                        <canvas id="order-chart" width="485" height="242" style="display: block; box-sizing: border-box; height: 194px; width: 388px;"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <p class="card-title">Revenue Report</p>
                                            <a href="#" class="text-info">View all</a>
                                        </div>
                                        <p class="font-weight-500">Description</p>
                                        <div id="sales-chart-legend" class="chartjs-legend mt-4 mb-2"><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul><ul>
                                        <li>
                                            <span style="background-color: #98BDFF"></span>
                                            Offline Sales
                                        </li>
                                        
                                        <li>
                                            <span style="background-color: #4B49AC"></span>
                                            Online Sales
                                        </li>
                                        </ul></div>
                                        <canvas id="sales-chart" width="485" height="242" style="display: block; box-sizing: border-box; height: 194px; width: 388px;"></canvas>
                                        </div>
                                    </div>
                                    </div>
                            </div>

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
                                                <p class="card-title">Booking Reports</p>
                                                <p class="mb-2 mb-xl-0">Description</p>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-xl-9">
                                                <div class="row">
                                                <div class="col-md-6 border-right">
                                                    <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                    <table class="table table-borderless report-table">
                                                        <tbody><tr>
                                                        <td class="text-muted">Pasay</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">713</h5>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="text-muted">Cubao</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">583</h5>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="text-muted">Marikina</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">924</h5>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="text-muted">Catbalogan</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">664</h5>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="text-muted">Kanangga</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">560</h5>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="text-muted">Maasin</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">793</h5>
                                                        </td>
                                                        </tr>
                                                    </tbody></table>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mt-3">
                                                    <div class="daoughnutchart-wrapper">
                                                    <canvas id="south-america-chart" height="250" style="display: block; box-sizing: border-box; height: 200px; width: 200px;" width="250"></canvas>
                                                    </div>
                                                    <div id="south-america-chart-legend"><ul>
                                                    <li>
                                                        <span style="background-color: #4B49AC"></span>
                                                        Confirmed Bookings
                                                    </li>
                                                    
                                                    <li>
                                                        <span style="background-color: #FFC100"></span>
                                                        Pending Bookings
                                                    </li>
                                                    
                                                    <li>
                                                        <span style="background-color: #248AFD"></span>
                                                        Cancelled Bookings
                                                    </li>
                                                    </ul><ul>
                                                    <li>
                                                        <span style="background-color: #4B49AC"></span>
                                                        Offline sales
                                                    </li>
                                                    
                                                    <li>
                                                        <span style="background-color: #FFC100"></span>
                                                        Online sales
                                                    </li>
                                                    
                                                    <li>
                                                        <span style="background-color: #248AFD"></span>
                                                        Returns
                                                    </li>
                                                    </ul></div>
                                                </div>
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