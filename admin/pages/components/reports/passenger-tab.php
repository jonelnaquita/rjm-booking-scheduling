<div class="table-responsive" style="margin-top: 20px;">
    <table id="table-example" class="table table-data2 nowrap dt-responsive w-100" style="margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Passenger Code</th>
                <th>Full Name</th>
                <th>City</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Full Address</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include '../../models/conn.php'; // Include your database connection

                // Query to fetch passenger data
                $query = "SELECT p.passenger_code, p.firstname, p.middlename, p.lastname, 
                            CONCAT(p.firstname, ' ', p.middlename, ' ', p.lastname) AS fullname, 
                            p.city, p.email, p.mobile_number, p.full_address, p.date_created
                          FROM tblpassenger p
                          LEFT JOIN tblbooking b ON p.passenger_code = b.passenger_id
                          WHERE b.status = 'Confirmed'";
                $result = $conn->query($query);

                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    $counter = 1; // Initialize counter for row numbering
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . $counter++ . '</td>
                            <td>' . $row['passenger_code'] . '</td>
                            <td>' . strtoupper($row['fullname']) . '</td>
                            <td>' . strtoupper($row['city']) . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['mobile_number'] . '</td>
                            <td>' . $row['full_address'] . '</td>
                            <td>' . date("F j, Y", strtotime($row['date_created'])) . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="8">No records found</td></tr>';
                }
                ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    // Get today's date in the format YYYY-MM-DD
    var today = new Date().toISOString().slice(0, 10);

    // Initialize the DataTable with export buttons
    $('#table-example').DataTable({
        dom: "<'row'<'col-sm-12 col-md-6 text-left'B><'col-sm-12 col-md-6'l>>" +
             "<'row'<'col-sm-12'tr>>" + 
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", // Position buttons in the top left
        buttons: [
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv"></i> Download CSV',
                className: 'btn btn-light btn-rounded btn-material shadow-sm',
                filename: 'RJM-PassengerReport_' + today,  // Set the filename
                exportOptions: {
                    columns: ':visible' // Export only visible columns
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Download PDF',
                className: 'btn btn-light btn-rounded btn-material shadow-sm',
                orientation: 'landscape',
                pageSize: 'A4',
                filename: 'RJM-PassengerReport_' + today,  // Set the filename
                exportOptions: {
                    columns: ':visible' // Export only visible columns
                },
                customize: function (doc) {
                    // Add a custom header to the PDF
                    doc.content.splice(0, 0, {
                        text: 'RJM Passenger Report',
                        fontSize: 14,
                        alignment: 'center',
                        margin: [0, 0, 0, 20]  // Adjust margin for spacing
                    });
                }
            }
        ],
        responsive: false, // Enable responsiveness
        columnDefs: [
            { orderable: false, targets: 0 }, // Disable ordering on the first column
        ]
    });
});
</script>


