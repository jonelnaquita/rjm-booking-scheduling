<!DOCTYPE html>
<html lang="en">
<?php
include '../api/session.php';
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
                    <h3 class="tab-title">Bus Management</h3>

                    <div class="row align-items-center" style="margin-bottom: 20px;">
                        <div class="col-auto">
                            <!-- Dropdown for Add Items -->
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Add Items
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                                    <h6 class="dropdown-header">Add Items</h6>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#new-bus">New
                                        Bus</a>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#bus-type">Bus
                                        Type</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table-responsive-data2">
                                <table id="bus-table" class="table table-hover"
                                    style="margin-top: 20px; margin-bottom: 20px;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Bus Number</th>
                                            <th>Type</th>
                                            <th>Seats</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '../api/bus/fetch-buses.php';
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


                <!--Include Footer -->
                <?php
                include '../modal/bus-modal.php';
                include '../components/footer.php';
                ?>

            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>
</body>

<script>
    $(document).ready(function () {
        new DataTable('#bus-table', {
            paging: true,         // Enable pagination
            searching: true,      // Enable search box
            info: true            // Show "Showing X to Y of Z entries" information
        });
    });
</script>


<!--Fetch Bus Type-->
<script>
    function loadBusTypes() {
        $.ajax({
            url: '../api/bus/fetch-bus-type.php',
            method: 'GET',
            success: function (response) {
                const busTypes = JSON.parse(response);
                let tableContent = '';
                busTypes.forEach(function (busType) {
                    tableContent += `
                        <tr>
                            <td>${busType.bus_type}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm edit-btn" data-id="${busType.bustype_id}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger btn-sm delete-bus-type" data-id="${busType.bustype_id}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </td>
                        </tr>`;
                });
                $('.table-bus-type tbody').html(tableContent);
            }
        });
    }

    //Delete Bus Type

    $(document).ready(function () {
        loadBusTypes(); // Load bus types on page load
    });

    $(document).on('click', '.delete-bus-type', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '../api/bus/delete-bus-type.php',
            method: 'POST',
            data: { id: id },
            success: function () {
                loadBusTypes(); // Refresh table after deletion
            }
        });
    });

    //Enable Add Button
    $(document).ready(function () {
        $('input[name="bus-type"], textarea[name="description"]').on('input', function () {
            let busType = $('input[name="bus-type"]').val().trim();
            let description = $('textarea[name="description"]').val().trim();

            if (busType !== "" && description !== "") {
                $('.add-bus-type').prop('disabled', false);
            } else {
                $('.add-bus-type').prop('disabled', true);
            }
        });
    });



    // Add New Bus Type
    $(document).ready(function () {
        $('.add-bus-type').on('click', function () {
            let busType = $('input[name="bus-type"]').val().trim();
            let description = $('textarea[name="description"]').val().trim();

            $.ajax({
                url: '../api/bus/add-bus-type.php',
                method: 'POST',
                data: {
                    bus_type: busType,
                    description: description
                },
                success: function (response) {
                    if (response === "success") {
                        toastr.success('Bus type added successfully.');
                        loadBusTypes(); // Refresh the table to show the new entry
                    } else {
                        alert("There was an error adding the bus type. Please try again.");
                    }
                }
            });
        });
    });

</script>


<!--Edit Bus Type-->
<script>
    $(document).ready(function () {

        // Handle Edit button click
        $(document).on('click', '.edit-btn', function () {
            // Get bus type ID from the data-id attribute
            let busTypeId = $(this).data('id');

            // Fetch the bus type data from the database using AJAX
            $.ajax({
                url: '../api/bus/get-bus-type.php', // PHP script to fetch a specific bus type by ID
                method: 'GET',
                data: { id: busTypeId },
                success: function (response) {
                    const busType = JSON.parse(response);

                    // Populate the modal input fields with the bus type data
                    $('.bus-type-id').val(busType.bustype_id);
                    $('input[name="bus-type"]').val(busType.bus_type);
                    $('textarea[name="description"]').val(busType.description);

                    // Enable the "Save" button
                    $('.save-bus-type').prop('disabled', false);

                    // Show the modal
                    $('#bus-type').modal('show');
                }
            });
        });

        // Enable "Save" button when both fields have values
        $('input[name="bus-type"], textarea[name="description"]').on('input', function () {
            let busType = $('input[name="bus-type"]').val().trim();
            let description = $('textarea[name="description"]').val().trim();

            if (busType !== "" && description !== "") {
                $('.save-bus-type').prop('disabled', false);
            } else {
                $('.save-bus-type').prop('disabled', true);
            }
        });

        // Handle the Save button click
        $('.save-bus-type').on('click', function () {
            let busTypeId = $('.bus-type-id').val().trim();
            let busType = $('input[name="bus-type"]').val().trim();
            let description = $('textarea[name="description"]').val().trim();

            // Send the updated data to the server via AJAX
            $.ajax({
                url: '../api/bus/update-bus-type.php', // PHP script to update the bus type
                method: 'POST',
                data: {
                    bustype_id: busTypeId,
                    bus_type: busType,
                    description: description
                },
                success: function (response) {
                    if (response === "success") {
                        $('#bus-type').modal('hide');
                        loadBusTypes(); // Refresh the table to show the updated entry
                    } else {
                        alert("There was an error updating the bus type. Please try again.");
                    }
                }
            });
        });
    });

</script>


<!--Adding New Bus -->
<script>
    $(document).ready(function () {
        // Load bus types when the modal is opened
        $('#new-bus').on('show.bs.modal', function () {
            $.ajax({
                url: '../api/bus/fetch-bus-type.php', // PHP script to fetch bus types
                method: 'GET',
                success: function (response) {
                    const busTypes = JSON.parse(response);
                    let options = '<option value="" disabled selected>Select Bus Type</option>';

                    busTypes.forEach(function (busType) {
                        options += `<option value="${busType.bustype_id}">${busType.bus_type}</option>`;
                    });

                    $('#bus-type-id').html(options);
                }
            });
        });

        $('input[name="bus-number"], #bus-type-id, .terminal_id, .destination-to, input[name="bus-seats"]').on('change input', function () {
            let busNumber = $('input[name="bus-number"]').val().trim();
            let busTypeId = $('#bus-type-id').val();
            let terminalId = $('.terminal_id').val();
            let destinationId = $('.destination-to').val();
            let busSeats = $('input[name="bus-seats"]').val().trim();

            if (busNumber !== "" && busTypeId !== null && terminalId !== null && destinationId !== null && busSeats !== "") {
                $('.add-new-bus').prop('disabled', false);
            } else {
                $('.add-new-bus').prop('disabled', true);
            }
        });

        // Handle the Add New Bus button click
        $('.add-new-bus').on('click', function () {
            let busNumber = $('input[name="bus-number"]').val().trim();
            let busTypeId = $('#bus-type-id').val();
            let terminalId = $('.terminal_id').val();
            let destinationId = $('.destination-to').val();
            let busSeats = $('input[name="bus-seats"]').val().trim();

            // Send the new bus data to the server via AJAX
            $.ajax({
                url: '../api/bus/add-new-bus.php', // PHP script to save the new bus
                method: 'POST',
                data: {
                    bus_number: busNumber,
                    bustype_id: busTypeId,
                    terminal_id: terminalId,
                    destination_id: destinationId,
                    seats: busSeats
                },
                success: function (response) {
                    if (response === "success") {
                        $('#new-bus').modal('hide');
                        toastr.success('New bus added successfully.');
                        setTimeout(function () {
                            location.reload(); // Refresh the page
                        }, 1000);
                    } else {
                        alert("There was an error adding the new bus. Please try again.");
                    }
                }
            });
        });
    });

</script>


<!-- Update Bus Script -->
<script>
    $(document).ready(function () {
        // Handle the edit button click to fetch bus details
        $(document).on('click', '.edit-button', function () {
            var busId = $(this).data('id'); // Get the bus ID from the button's data-id attribute

            $('#update-bus').data('bus-id', busId); // Store bus ID in modal

            // Fetch bus details
            $.ajax({
                url: '../api/bus/fetch-bus-details.php',
                method: 'GET',
                data: { bus_id: busId },
                success: function (response) {
                    const busData = JSON.parse(response);

                    // Populate form fields
                    $('input[name="update-bus-number"]').val(busData.bus_number);
                    $('input[name="update-bus-seats"]').val(busData.seats);

                    // Populate Bus Type dropdown
                    $.ajax({
                        url: '../api/bus/fetch-bus-type.php',
                        method: 'GET',
                        success: function (busTypeResponse) {
                            const busTypes = JSON.parse(busTypeResponse);
                            let busTypeOptions = '<option value="" disabled>Select Bus Type</option>';

                            busTypes.forEach(function (busType) {
                                busTypeOptions += `<option value="${busType.bustype_id}" ${busData.bus_type == busType.bustype_id ? 'selected' : ''}>${busType.bus_type}</option>`;
                            });

                            $('#bus-type-update').html(busTypeOptions).trigger('change');
                        }
                    });

                    // Terminal Dropdown
                    $.ajax({
                        url: '../api/schedule/fetch-destination-from.php',
                        method: 'GET',
                        success: function (terminalResponse) {
                            const terminals = typeof terminalResponse === "string" ? JSON.parse(terminalResponse) : terminalResponse;

                            let terminalOptions = '<option value="" disabled>Select Destination From</option>';
                            if (Array.isArray(terminals)) {
                                terminals.forEach(function (terminal) {
                                    terminalOptions += `<option value="${terminal.from_id}" ${busData.terminal_id == terminal.from_id ? 'selected' : ''}>${terminal.destination_from}</option>`;
                                });
                            } else {
                                console.error("Invalid terminals data", terminals);
                            }

                            $('.update_terminal_id').html(terminalOptions).trigger('change');
                        }
                    });

                    $.ajax({
                        url: '../api/bus/fetch-destination-to.php',
                        method: 'POST',
                        data: { from_id: busData.terminal_id }, // Pass `from_id` to the backend
                        success: function (destinationResponse) {
                            console.log("Destination Response: ", destinationResponse);

                            // Parse the response
                            const destinations = typeof destinationResponse === "string" ? JSON.parse(destinationResponse) : destinationResponse;

                            // Default placeholder option using busData.terminal_id
                            let destinationOptions = '<option value="" disabled>Select Destination To</option>';

                            if (Array.isArray(destinations)) {
                                destinations.forEach(function (destination) {
                                    destinationOptions += `
                    <option value="${destination.from_id}" ${busData.destination_id == destination.to_id ? 'selected' : ''}>
                        ${destination.destination_from} <!-- Display destination_from here -->
                    </option>`;
                                });
                            } else {
                                console.error("Invalid destinations data", destinations);
                            }

                            // Populate the dropdown with options
                            $('.update-destination-to').html(destinationOptions).trigger('change');
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching destinations:", status, error, xhr.responseText);
                        }
                    });




                },
                error: function () {
                    toastr.error('Error fetching bus details.');
                }
            });
        });



        // Handle bus update submission
        $('.update-bus-btn').on('click', function () {
            let busId = $('#update-bus').data('bus-id');
            let busNumber = $('input[name="update-bus-number"]').val().trim();
            let busTypeId = $('#bus-type-update').val();
            let terminalId = $('.update_terminal_id').val();
            let destinationId = $('.update-destination-to').val();
            let busSeats = $('input[name="update-bus-seats"]').val().trim();

            $.ajax({
                url: '../api/bus/update-bus.php',
                method: 'POST',
                data: {
                    bus_id: busId,
                    bus_number: busNumber,
                    bus_type_id: busTypeId,
                    terminal_id: terminalId,
                    destination_id: destinationId,
                    seats: busSeats
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        toastr.success('Bus updated successfully!');
                        $('#update-bus').modal('hide');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error('Failed to update bus. Please try again.');
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });

    });
</script>

<!-- Delete Bus-->
<script>
    $(document).ready(function () {
        let busIdToDelete; // Variable to hold the bus ID to delete

        // Capture the bus ID when the delete button is clicked
        $(document).on('click', '.delete-button', function () {
            busIdToDelete = $(this).data('id'); // Get bus ID from the button's data-id attribute
        });

        // Handle confirm delete button click in the modal
        $('#confirm-delete-btn').on('click', function () {
            // Send AJAX request to delete the bus
            $.ajax({
                url: '../api/bus/delete-bus.php', // The PHP script that handles deletion
                type: 'POST',
                data: { bus_id: busIdToDelete }, // Send the bus ID to the server
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        toastr.success('Bus deleted successfully!', 'Success');
                        $('#confirm-delete').modal('hide');
                        // Add a 1-second delay before reloading the page
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error('Failed to delete the bus. Please try again.');
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });
</script>






</html>