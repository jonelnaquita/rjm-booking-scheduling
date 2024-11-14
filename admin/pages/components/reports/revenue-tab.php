<div class="table-responsive" style="margin-top: 20px;">
    <table id="revenue-table" class="table table-data2 nowrap dt-responsive w-100"
        style="margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Passenger Code</th>
                <th>Trip Type</th>
                <th>Passenger</th>
                <th>Amount</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../models/conn.php'; // Include database connection
            
            $query = "SELECT passenger_id, trip_type, passengers, price, date_created FROM tblbooking WHERE status = 'Confirmed'";
            $result = $conn->query($query);

            $totalAmount = 0; // Store total amount
            $index = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $price = number_format((float) $row['price'], 2, '.', ',');
                    $totalAmount += $row['price'];

                    echo "<tr>
                            <td>{$index}</td>
                            <td>{$row['passenger_id']}</td>
                            <td>{$row['trip_type']}</td>
                            <td>{$row['passengers']}</td>
                            <td>₱{$price}</td>
                            <td>" . date('F d, Y h:i A', strtotime($row['date_created'])) . "</td>
                          </tr>";
                    $index++;
                }
            } else {
                echo "<tr><td colspan='6'>No data found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <th style="text-align: right;">Total Revenue</th>
                <th>₱<?php echo number_format($totalAmount, 2, '.', ','); ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>



<script>
    $(document).ready(function () {
        var today = new Date().toISOString().slice(0, 10);

        $('#revenue-table').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6 text-left'B><'col-sm-12 col-md-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> Download CSV',
                    className: 'btn btn-light btn-rounded btn-material shadow-sm',
                    filename: 'RJM-RevenueReport_' + today,
                    footer: true,
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> Download PDF',
                    className: 'btn btn-light btn-rounded btn-material shadow-sm',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    filename: 'RJM-RevenueReport_' + today,
                    footer: true,
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    },
                    customize: function (doc) {
                        doc.content[0].margin = [0, 0, 0, 0];
                        doc.content.unshift({
                            text: 'Revenue Report',
                            fontSize: 14,
                            alignment: 'center',
                            margin: [0, 0, 0, 20]
                        });
                    }
                }
            ],
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 0 },
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Calculate total revenue across all pages
                var totalRevenue = api.column(4, { page: 'all' }).data()
                    .reduce(function (a, b) {
                        return a + parseFloat(b.replace(/[₱,]/g, '')) || 0;
                    }, 0);

                // Update footer
                $(api.column(4).footer()).html('₱' + totalRevenue.toLocaleString());
            }
        });
    });
</script>