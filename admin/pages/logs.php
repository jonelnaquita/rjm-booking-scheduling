<!DOCTYPE html>
<html lang="en">
<?php
include '../api/session.php';
include '../../models/conn.php';
include '../components/header.php';
?>

<head>
    <!-- Include Font Awesome for icons -->


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
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table id="logs-table" class="table table-data2 nowrap dt-responsive w-100"
                            style="margin-top: 20px; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Staff Name</th>
                                    <th>Terminal</th>
                                    <th>Logs</th>
                                </tr>
                            </thead>
                            <tbody>
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
        var table = $('#logs-table').DataTable({
            "aLengthMenu": [[10, 25, -1], [10, 25, 50, "All"]],
            "iDisplayLength": 10
        });

        fetchLogs();

        function fetchLogs() {
            $.ajax({
                url: '../api/logs/fetch-logs.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    let logsTable = $('#logs-table tbody');
                    logsTable.empty(); // Clear existing data

                    data.forEach((log, index) => {
                        let row = `
                        <tr>
                            <td>${log.index}</td>
                            <td>${log.staff_name}</td>
                            <td>${log.destination_from}</td>
                            <td>${log.action}</td>
                        </tr>
                    `;
                        logsTable.append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching logs:", error);
                }
            });
        }
    });
</script>





</html>