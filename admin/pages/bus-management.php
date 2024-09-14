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
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Add Items
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                                    <h6 class="dropdown-header">Add Items</h6>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#new-bus">New Bus</a>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#bus-type">Bus Type</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                        include '../api/bus/fetch-buses.php';
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table-responsive-data2">
                                <table id="bus-table" class="table table-hover" style="margin-top: 20px; margin-bottom: 20px;">
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
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr class='tr-shadow'>
                                                        <td>
                                                            <label class='au-checkbox'>
                                                                <input type='checkbox'>
                                                                <span class='au-checkmark'></span>
                                                            </label>
                                                        </td>
                                                        <td>{$row['bus_number']}</td>
                                                        <td class='desc'>{$row['bus_type']}</td>
                                                        <td class='desc'>{$row['seats']}</td>
                                                        <td>
                                                            <span class='block-email'>{$row['status']}</span>
                                                        </td>
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
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>No buses found.</td></tr>";
                                        }
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
    $(document).ready(function() {
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
            success: function(response) {
                const busTypes = JSON.parse(response);
                let tableContent = '';
                busTypes.forEach(function(busType) {
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

    $(document).ready(function() {
        loadBusTypes(); // Load bus types on page load
    });

    $(document).on('click', '.delete-bus-type', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '../api/bus/delete-bus-type.php',
            method: 'POST',
            data: { id: id },
            success: function() {
                loadBusTypes(); // Refresh table after deletion
            }
        });
    });

    //Enable Add Button
    $(document).ready(function() {
        $('input[name="bus-type"], textarea[name="description"]').on('input', function() {
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
    $(document).ready(function() {
        $('.add-bus-type').on('click', function() {
            let busType = $('input[name="bus-type"]').val().trim();
            let description = $('textarea[name="description"]').val().trim();

            $.ajax({
                url: '../api/bus/add-bus-type.php',
                method: 'POST',
                data: {
                    bus_type: busType,
                    description: description
                },
                success: function(response) {
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
    $(document).ready(function() {

    // Handle Edit button click
    $(document).on('click', '.edit-btn', function() {
        // Get bus type ID from the data-id attribute
        let busTypeId = $(this).data('id');
        
        // Fetch the bus type data from the database using AJAX
        $.ajax({
            url: '../api/bus/get-bus-type.php', // PHP script to fetch a specific bus type by ID
            method: 'GET',
            data: { id: busTypeId },
            success: function(response) {
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
    $('input[name="bus-type"], textarea[name="description"]').on('input', function() {
        let busType = $('input[name="bus-type"]').val().trim();
        let description = $('textarea[name="description"]').val().trim();

        if (busType !== "" && description !== "") {
            $('.save-bus-type').prop('disabled', false);
        } else {
            $('.save-bus-type').prop('disabled', true);
        }
    });

    // Handle the Save button click
    $('.save-bus-type').on('click', function() {
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
            success: function(response) {
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
    $(document).ready(function() {
    // Load bus types when the modal is opened
    $('#new-bus').on('show.bs.modal', function() {
        $.ajax({
            url: '../api/bus/fetch-bus-type.php', // PHP script to fetch bus types
            method: 'GET',
            success: function(response) {
                const busTypes = JSON.parse(response);
                let options = '<option value="" disabled selected>Select Bus Type</option>';
                
                busTypes.forEach(function(busType) {
                    options += `<option value="${busType.bustype_id}">${busType.bus_type}</option>`;
                });

                $('#bus-type-id').html(options);
            }
        });
    });

    // Enable "Add" button when both fields have values
    $('input[name="bus-number"], #bus-type-id').on('change input', function() {
        let busNumber = $('input[name="bus-number"]').val().trim();
        let busTypeId = $('#bus-type-id').val();

        if (busNumber !== "" && busTypeId !== null) {
            $('.add-new-bus').prop('disabled', false);
        } else {
            $('.add-new-bus').prop('disabled', true);
        }
    });

    // Handle the Add New Bus button click
    $('.add-new-bus').on('click', function() {
        let busNumber = $('input[name="bus-number"]').val().trim();
        let busTypeId = $('#bus-type-id').val();
        let busSeats = $('input[name="bus-seats"]').val().trim();

        // Send the new bus data to the server via AJAX
        $.ajax({
            url: '../api/bus/add-new-bus.php', // PHP script to save the new bus
            method: 'POST',
            data: {
                bus_number: busNumber,
                bustype_id: busTypeId,
                busSeats: busSeats
            },
            success: function(response) {
                if (response === "success") {
                    $('#new-bus').modal('hide');
                    toastr.success('New bus added successfully.');
                    setTimeout(function() {
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



</html>