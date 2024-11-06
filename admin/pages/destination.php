<!DOCTYPE html>
<html lang="en">
<?php
include '../api/session.php';
include '../../models/conn.php';
include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">

    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        .drop-off-col {
            width: 50%;
            /* Adjust this percentage as needed */
        }

        .action-col {
            width: 50%;
            /* Adjust this percentage as needed */
        }
    </style>
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
                    <h3 class="tab-title">Destination Overview</h3>

                    <div class="row">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm" type="button" id="dropdownMenuSizeButton3"
                                data-bs-toggle="modal" data-bs-target="#add-destination" aria-expanded="false"> Add
                                Items </button>
                        </div>
                    </div>


                    <?php
                    include '../api/fetch-all-route.php';
                    ?>


                    <div class="row destination-section">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <div class="col-lg-3">
                                <div class="card card-margin">
                                    <div class="card-body pt-0">
                                        <div class="widget-49">
                                            <h5 class="card-title"><?php echo htmlspecialchars($row['from_name']); ?></h5>
                                            <!--<p class="card-text" style="margin-top: -15px;"></?php echo htmlspecialchars($row['province_name']); ?></p>-->
                                            <div class="card-description" style="display: none;">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Drop-off Locations</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $from_id = $row['from_id'];
                                                            if (isset($destinationsByFromId[$from_id])) {
                                                                foreach ($destinationsByFromId[$from_id] as $destination) {
                                                                    // Get the corresponding to_id from the result
                                                                    $to_id = ''; // Default value if not found
                                                                    while ($destRow = $destinationsResult->fetch_assoc()) {
                                                                        if ($destRow['from_id'] == $from_id && $destRow['from_name'] == $destination) {
                                                                            $to_id = $destRow['to_id'];
                                                                            break;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo htmlspecialchars($destination); ?>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button"
                                                                                class="btn btn-danger text-light btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#deleteDestination"
                                                                                data-id="<?php echo htmlspecialchars($destination); ?>"
                                                                                data-from-id="<?php echo htmlspecialchars($from_id); ?>">Delete</button>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <ul>

                                                </ul>
                                                <div class="widget-49-meeting-action">
                                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                                        data-bs-target="#destination-modal"
                                                        data-pickup-id="<?php echo $row['from_id']; ?>">Add</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="widget-49-meeting-action">
                                                    <button class="btn btn-sm btn-primary" onclick="toggleCard(this)">
                                                        <i class="fas fa-eye mr-2"></i> View Drop Location
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-id="<?php echo htmlspecialchars($row['from_id']); ?>">
                                                        <i class="fas fa-trash-alt mr-2"></i> Delete
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>

                <?php
                include '../modal/destination-modal.php';
                ?>

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
    function toggleCard(button) {
        var card = button.closest('.card');
        var description = card.querySelector('.card-description');
        if (description.style.display === "none") {
            description.style.display = "block";
        } else {
            description.style.display = "none";
        }
    }
</script>

<script>
    $(document).ready(function () {
        $('.destination-to').select2({
            dropdownParent: $('#destination-modal'),
            width: '100%' // Ensure full width
        });
    });
</script>

<!-- Button to Open Modal with pickup_id -->

<script>
    // When the modal is shown, set the pickup-location input value
    $('#destination-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var pickupId = button.data('pickup-id'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('#pickup-location').val(pickupId);
    });
</script>

<!-- Delete Destination-->
<script>
    $(document).ready(function () {
        // Event listener for the delete button
        $('.delete-btn').click(function () {
            var from_id = $(this).data('id'); // Get the from_id from the button's data-id attribute

            // SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "This location will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, send the AJAX request to delete the location
                    $.ajax({
                        url: '../api/destination/delete-destination.php', // The PHP file that will handle the deletion
                        type: 'POST',
                        data: { from_id: from_id },
                        success: function (response) {
                            // If the deletion was successful
                            if (response == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'The location has been deleted.',
                                    'success'
                                ).then(() => {
                                    // Reload the page after success
                                    location.reload();
                                });
                                // Optionally, you can remove the deleted row from the table
                                $('button[data-id="' + from_id + '"]').closest('tr').remove();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the location.',
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'There was a problem with the AJAX request.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    function submitForm() {
        // Get the value of the pick-up location (from_id)
        const fromId = document.getElementById('pickup-location').value;

        // Get the selected drop-off locations
        const dropOffSelect = document.querySelector('.destination-to');
        const dropOffLocations = Array.from(dropOffSelect.selectedOptions).map(option => option.value);

        // Prepare the data to be sent
        const data = {
            pickup_id: fromId,
            drop_off: dropOffLocations
        };

        // AJAX request to send the data to the server
        fetch('../api/insert-dropoff.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    toastr.success('Drop-off locations added successfully!');
                    setTimeout(() => {
                        location.reload(); // Reload the page after a delay
                    }, 2000); // 2000 milliseconds (2 seconds) delay
                } else {
                    toastr.error('Failed to add drop-off locations.');
                    setTimeout(() => {
                        location.reload(); // Reload the page after a delay
                    }, 2000); // 2000 milliseconds (2 seconds) delay
                }
            })
            .catch(error => {
                toastr.error('An error occurred. Please try again.');
                setTimeout(() => {
                    location.reload(); // Reload the page after a delay
                }, 2000); // 2000 milliseconds (2 seconds) delay
                console.error('Error:', error);
            });
    }
</script>

<script>
    $(document).ready(function () {
        // Initialize Select2
        $('.destination-to').select2({
            dropdownParent: $('#destination-modal'),
            width: '100%' // Ensure full width
        });

        // Handle button click to open modal
        $('button[data-bs-toggle="modal"]').on('click', function () {
            // Get the pickup_id from data attribute
            var pickup_id = $(this).data('pickup-id');

            // Store pickup_id in a hidden input or other suitable place if needed
            $('#pickup-location').val(pickup_id);

            // Fetch available destinations
            $.ajax({
                url: '../api/fetch-available-route.php', // Update this with the path to your PHP script
                type: 'POST',
                data: { pickup_id: pickup_id },
                dataType: 'json',
                success: function (data) {
                    // Clear existing options
                    $('.destination-to').empty();

                    // Add options and set disabled status
                    data.forEach(function (destination) {
                        var option = new Option(destination.destination_from, destination.from_id, false, false);
                        $(option).prop('disabled', destination.disabled);
                        $('.destination-to').append(option);
                    });

                    // Refresh Select2 to apply changes
                    $('.destination-to').trigger('change');
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });
    });
</script>



<!--Save Destination Entry-->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Handle the save button click event
        document.querySelector('.save-destination').addEventListener('click', function () {
            // Get values from the input fields
            var destination = document.querySelector('#destination-input').value;

            // Check if destination and province have values
            if (!destination) {
                toastr.error('Please fill out all required fields.');
                return;
            }

            // Prepare the data to be sent
            var data = {
                destination: destination
            };

            // Perform AJAX request
            fetch('../api/destination/add-destination.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        toastr.success(result.message);
                        $('#add-destination').modal('hide'); // Hide the modal
                        // Add a delay before reloading the page
                        setTimeout(function () {
                            location.reload(); // Refresh the page
                        }, 2000); // 2000ms delay (2 seconds)
                    } else {
                        toastr.error(result.message);
                    }
                })

                .catch(error => {
                    toastr.error('An error occurred. Please try again.');
                    console.error('Error:', error);
                });
        });
    });

</script>

<!-- JavaScript for Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteButtons = document.querySelectorAll('button[data-bs-toggle="modal"][data-bs-target="#deleteDestination"]');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var toId = this.getAttribute('data-id');
                var fromId = this.getAttribute('data-from-id');

                var modalInputToId = document.getElementById('edit-id');
                var modalInputFromId = document.getElementById('from-id');

                modalInputToId.value = toId;
                modalInputFromId.value = fromId;
            });
        });

        document.getElementById('confirm-delete').addEventListener('click', function () {
            var toId = document.getElementById('edit-id').value;
            var fromId = document.getElementById('from-id').value;

            if (toId && fromId) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../api/destination/delete-drop-off.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        toastr.success('Destination deleted successfully.');
                        setTimeout(function () {
                            location.reload(); // Refresh the page
                        }, 1000);
                    } else {
                        toastr.error('An error occurred while deleting the destination.');
                        setTimeout(function () {
                            location.reload(); // Refresh the page
                        }, 1000);
                    }
                };
                xhr.send('to_id=' + encodeURIComponent(toId) + '&from_id=' + encodeURIComponent(fromId));
            } else {
                alert('Invalid data.');
            }
        });
    });
</script>




</html>