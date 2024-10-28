<div class="row filter-field" id="filter-field" style="margin-bottom: 20px; margin-top: 20px;">
    <div class="col-12 col-md-auto mt-2 mt-md-0">
        <div class="row">
            <div class="col">
                <select class="form-select form-select-sm" id="direction-filter">
                    <option value="" selected>Filter by Direction</option>
                    <option value="Departure">Departure</option>
                    <option value="Arrival">Arrival</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-auto mb-2 mb-md-0">
        <div class="row gx-2 align-items-center">
            <div class="col">
                <!-- Date Picker -->
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Select Date" id="datepicker">
                </div>
            </div>
            <div class="col">
                <!-- Time Picker -->
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Select Time" id="timepicker">
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown Menu -->
    <div class="col-12 col-md-auto mt-2 mt-md-0">
        <div class="row">
            <div class="col">
                <select class="form-select form-select-sm" id="bus-filter">
                    <option value="">Filter by Bus</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Clear Button -->
    <div class="col-12 col-md-auto mt-2 mt-md-0">
        <button id="clear-filters" class="btn btn-sm btn-secondary text-light">Clear Filters</button>
    </div>
</div>

<div class="table-responsive ">
    <table id="booking-table" class="table table-data2 nowrap dt-responsive w-100" style="margin-top: 20px; margin-bottom: 20px;">
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
            </tr>
        </thead>
        <tbody>
            <?php
                // SQL query to fetch booking details without conditions
                $sql = "SELECT
                    b.book_id AS booking_id,
                    b.passenger_id AS book_id,
                    CONCAT(p.firstname, ' ', IFNULL(p.middlename, ''), ' ', p.lastname) AS fullname,
                    b.trip_type,
                    departure_route.destination_from AS departure_destination,
                    IFNULL(arrival_route.destination_from, 'N/A') AS arrival_destination,
                    departure_schedule.departure_date AS departure_date,
                    departure_schedule.departure_time AS departure_time,
                    IFNULL(arrival_schedule.departure_date, 'N/A') AS arrival_date,
                    IFNULL(arrival_schedule.departure_time, 'N/A') AS arrival_time,
                    CONCAT(bus.bus_number, ' - ', bt.bus_type) AS bus_info,
                    IFNULL(CONCAT(ba.bus_number, ' - ', bta.bus_type), 'N/A') AS bus_arrival,
                    b.price AS travel_cost,
                    b.passengers AS num_passengers,
                    b.status,
                    py.reference_number,
                    py.screenshot_filename
                FROM tblbooking b
                JOIN tblpassenger p ON b.passenger_id = p.passenger_code
                JOIN tblschedule departure_schedule ON b.scheduleDeparture_id = departure_schedule.schedule_id
                LEFT JOIN tblschedule arrival_schedule ON b.scheduleArrival_id = arrival_schedule.schedule_id
                JOIN tblroutefrom departure_route ON departure_schedule.destination_from = departure_route.from_id
                LEFT JOIN tblroutefrom arrival_route ON departure_schedule.destination_to = arrival_route.from_id
                JOIN tblbus bus ON departure_schedule.bus_id = bus.bus_id
                LEFT JOIN tblbus ba ON arrival_schedule.bus_id = ba.bus_id
                JOIN tblbustype bt ON bus.bus_type = bt.bustype_id
                LEFT JOIN tblbustype bta ON ba.bus_type = bta.bustype_id
                JOIN tblpayment py ON b.passenger_id = py.passenger_id
                WHERE b.status = 'Confirmed'
                ORDER BY departure_date ASC";


                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $count = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr class='tr-shadow'>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . strtoupper($row['fullname']) . "</td>";
                        
                        // Condition for destination
                        if ($row['trip_type'] == 'Round-Trip') {
                            echo "<td> <div class='badge badge-primary badge-pill mb-2'>" . $row['departure_destination'] . " to " . $row['arrival_destination'] . "</div> <br> <div class='badge badge-primary badge-pill'>" . $row['arrival_destination'] . " to " . $row['departure_destination'] . "</div></td>";
                        } else {
                            echo "<td> <div class='badge badge-primary badge-pill'>" . $row['departure_destination'] . " to " . $row['arrival_destination'] ."</div></td>";
                        }
                        
                        // Condition for schedule
                        if ($row['trip_type'] == 'Round-Trip') {
                            echo "<td> <div class='badge badge-primary badge-pill mb-2'>" . date('F j, Y', strtotime($row['departure_date'])) . " " . date('h:i A', strtotime($row['departure_time'])) . " (Departure)</div> <br> <div class='badge badge-primary badge-pill'>" . 
                                    date('F j, Y', strtotime($row['arrival_date'])) . " " . date('h:i A', strtotime($row['arrival_time'])) . " (Arrival)</div></td>";
                        } else {
                            echo "<td> <div class='badge badge-primary badge-pill'>" . date('F j, Y', strtotime($row['departure_date'])) . " " . date('h:i A', strtotime($row['departure_time'])) . "</div></td>";
                        }
                        
                        // Condition for bus information
                        if ($row['trip_type'] == 'Round-Trip') {
                            echo "<td>
                                    <div class='badge badge-primary badge-pill mb-2'>" . $row['bus_info'] . " (Departure)</div>
                                    <br>
                                    <div class='badge badge-primary badge-pill'>" . $row['bus_arrival'] . " (Arrival)</div>
                                </td>";
                        } else {
                            echo "<td>
                                    <div class='badge badge-primary badge-pill'>" . $row['bus_info'] . "</div>
                                </td>";
                        }
                        echo "<td>₱" . number_format($row['travel_cost'], 2) . "</td>";
                        echo "<td> <div class='badge badge-pill badge-outline-primary'>" . $row['num_passengers'] . "</div></td>";
                        echo "</tr>";
                        $count++;
                    }
                }
            ?>

        </tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    
});
</script>

<!--Filter-->
<script type="text/javascript">
    $(function () {
        // Initialize time picker and store its instance
        const timePickerInstance = $("#timepicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
        });

        // Initialize date picker and store its instance
        const datePickerInstance = $("#datepicker").flatpickr({
            altInput: true,
            dateFormat: "F j, Y"
        });

        // Clear filter inputs when "Clear Filters" button is clicked
        $('#clear-filters').on('click', function() {
            // Clear all filters
            $('#direction-filter').val('');  // Reset direction filter
            datePickerInstance.clear();      // Clear date picker using Flatpickr's clear method
            timePickerInstance.clear();      // Clear time picker using Flatpickr's clear method
            $('#bus-filter').val('');        // Reset bus filter

            // Trigger the redraw of the DataTable
            $('#booking-table').DataTable().draw();
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Fetch all bus numbers when the page loads
        $.ajax({
            url: '../api/booking/fetch-buses.php', // Adjust the URL to your actual path
            type: 'GET',
            dataType: 'json', // Expecting a JSON response
            success: function(response) {
                if (response.success) {
                    var buses = response.data; // Assuming the bus numbers are in the 'data' field
                    var $busFilter = $('#bus-filter');

                    // Clear the dropdown first
                    $busFilter.empty();

                    // Add the default option
                    $busFilter.append('<option value="">Filter by Bus</option>');

                    // Loop through each bus and append as options
                    buses.forEach(function(bus) {
                        $busFilter.append('<option value="' + bus.bus_id + '">' + bus.bus_number + '</option>');
                    });
                } else {
                    console.error('Failed to fetch buses:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching buses:', error);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        // Initialize the DataTable with export buttons
        var today = new Date().toISOString().slice(0, 10);  // Get today's date in the format YYYY-MM-DD

        var table = $('#booking-table').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6 text-left'B><'col-sm-12 col-md-6'l>>" +
                "<'row'<'col-sm-12'tr>>" + 
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", // Position buttons in the top left
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i> Download CSV',
                    className: 'btn btn-light btn-rounded btn-material shadow-sm',
                    filename: 'RJM-BookingReport_' + today,  // Set the filename
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
                    filename: 'RJM-BookingReport_' + today,  // Set the filename
                    exportOptions: {
                        columns: ':visible' // Export only visible columns
                    },
                    customize: function (doc) {
                        // Add a custom header to the PDF
                        doc.content.splice(0, 0, {
                            text: 'RJM Booking Report',
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


        // Event listener for Date Picker
        $('#datepicker').on('keyup change', function() {
            table.draw(); // Redraw the table on change
        });

        // Event listener for Time Picker
        $('#timepicker').on('keyup change', function() {
            table.draw(); // Redraw the table on change
        });

        // Event listener for Bus Filter Dropdown
        $('#bus-filter').on('change', function() {
            table.draw(); // Redraw the table on change
        });

        $('#direction-filter').on('change', function(){
            table.draw();
        })

        // Custom filtering function for DataTable
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var selectedDate = $('#datepicker').val().trim();  // Get the date from the Date Picker
            var selectedTime = $('#timepicker').val().trim();  // Get the time from the Time Picker
            var selectedBus = $('#bus-filter').val().trim();   // Get the bus from the Bus Filter
            var selectedDirection = $('#direction-filter').val().trim();

            // Assuming the Date is in the 5th column, Time in the 5th (part of Schedule), and Bus in the 6th
            var tableSchedule = data[4].trim(); // Column 5 for Schedule (Date and Time)
            var tableBus = data[5].trim();      // Column 6 for Bus

            // Check Date filter
            if (selectedDate && tableSchedule.indexOf(selectedDate) === -1) {
                return false;
            }

            // Check Time filter (optional: handle combined date and time or separate time)
            if (selectedTime && tableSchedule.indexOf(selectedTime) === -1) {
                return false;
            }

            // Check Bus filter
            if (selectedBus && tableBus.indexOf(selectedBus) === -1) {
                return false;
            }

            if (selectedDirection && tableSchedule.indexOf(selectedDirection) === -1) {
                return false;
            }

            return true; // If all filters pass, show the row
        });
    });
</script>


