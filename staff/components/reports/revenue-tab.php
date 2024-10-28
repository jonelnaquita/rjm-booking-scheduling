<div class="table-responsive" style="margin-top: 20px;">
    <table id="revenue-table" class="table table-data2 nowrap dt-responsive w-100" style="margin-top: 20px; margin-bottom: 20px;">
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

            // SQL query to fetch passenger_id, trip_type, passengers, and price from tblbooking
            $query = "SELECT b.passenger_id, b.trip_type, b.passengers, b.price, b.date_created, s.destination_from 
                      FROM tblbooking b
                      LEFT JOIN tblschedule s ON b.scheduleDeparture_id = s.schedule_id
                      WHERE b.status = 'Confirmed' AND s.destination_from = '$terminal'";
            $result = $conn->query($query);

            $totalAmount = 0; // Variable to store total amount
            $index = 1; // Variable to number the rows

            if ($result->num_rows > 0) {
                // Loop through each row and display in the table
                while ($row = $result->fetch_assoc()) {
                    $price = number_format((float)$row['price'], 2, '.', ','); // Format price
                    $totalAmount += $row['price']; // Add to total amount

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
                // Display a message if no data is found
                echo "<tr><td colspan='6'>No data found</td></tr>";
            }

            $conn->close(); // Close the database connection
            ?>
        </tbody>
        <!-- New div to display the total amount -->
        <div class="total-amount" style="text-align: right; margin-top: 10px; margin-right: 100px;">
            <strong>Total Revenue: ₱<?php echo number_format($totalAmount, 2, '.', ','); ?></strong>
        </div>
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
                exportOptions: {
                    columns: ':visible', // Export all visible columns
                    modifier: {
                        page: 'all' // Export all rows on all pages
                    }
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> Download PDF',
                className: 'btn btn-light btn-rounded btn-material shadow-sm',
                orientation: 'landscape',
                pageSize: 'A4',
                filename: 'RJM-RevenueReport_' + today,
                exportOptions: {
                    columns: ':visible', // Export all visible columns
                    modifier: {
                        page: 'all' // Export all rows on all pages
                    }
                },
                customize: function (doc) {
                    // Set margins to utilize full page width
                    doc.content[0].margin = [0, 0, 0, 0]; // left, top, right, bottom
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
        ]
    });
});
</script>
