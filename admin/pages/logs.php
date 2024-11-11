<!DOCTYPE html>
<html lang="en">
<?php
include '../api/session.php';
include '../../models/conn.php';
include '../components/header.php';
?>

<head>
    <!-- Add Bootstrap Datepicker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <!-- Add Bootstrap Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>



</head>

<body>

    <div class="container-scroller">
        <?php include '../components/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php
            include '../components/sidebar.php';
            ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Tab Indicator or Title -->
                    <h3 class="tab-title">Logs</h3>
                    <div class="table-responsive" style="margin-top: 20px; max-height: 100vh; overflow-y: scroll;">
                        <div class="form-group col-md-3 mb-3">
                            <label for="date-filter">Filter by Date:</label>
                            <input type="text" id="date-filter" class="form-control" placeholder="Select a date">
                        </div>

                        <table id="logs-table" class="table table-data2 nowrap dt-responsive w-100"
                            style="margin-top: 20px; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Staff Name</th>
                                    <th>Terminal</th>
                                    <th>Logs</th>
                                    <th>Date and Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be dynamically populated here -->
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

        <!--Include Footer -->
        <?php
        include '../components/footer.php';
        ?>

    </div>
</body>

<script>
    $(document).ready(function () {
        // Initialize Bootstrap Datepicker for filtering
        $('#date-filter').datepicker({
            format: 'mm/dd/yyyy',  // Use format that matches your backend date format
            autoclose: true,
            todayHighlight: true
        });

        // Trigger filter function when a date is selected
        $('#date-filter').on('change', function () {
            var selectedDate = $(this).val();
            fetchLogs(selectedDate);  // Fetch logs with selected date
        });

        // Function to fetch logs with date filter
        function fetchLogs(selectedDate = '') {
            $.ajax({
                url: '../api/logs/fetch-logs.php',
                type: 'GET',
                data: { date: selectedDate },  // Send the selected date as a filter
                dataType: 'json',
                success: function (data) {
                    let logsTable = $('#logs-table tbody');
                    logsTable.empty(); // Clear existing data in the table

                    // Append new rows to the table
                    data.forEach((log, index) => {
                        let row = `
                        <tr>
                            <td>${log.index}</td>
                            <td>${log.staff_name}</td>
                            <td>${log.destination_from}</td>
                            <td>${log.action}</td>
                            <td>${log.date_created}</td>
                        </tr>
                        `;
                        logsTable.append(row); // Add new row to the table body
                    });

                    // Redraw the table after appending data
                    table.clear().draw(); // Clear and redraw the DataTable
                    table.rows.add(logsTable.find('tr')).draw(); // Add new rows to DataTable and redraw
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching logs:", error);
                }
            });
        }

        // Initial fetch of logs when the page loads
        fetchLogs();
    });
</script>


</html>