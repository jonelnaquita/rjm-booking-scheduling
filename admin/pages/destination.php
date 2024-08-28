<?php
    include '../api/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php
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

        .table th, .table td {
            padding: 8px;
            text-align: left;
        }

        .drop-off-col {
            width: 50%; /* Adjust this percentage as needed */
        }

        .action-col {
            width: 50%; /* Adjust this percentage as needed */
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
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Add Items </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3" style="">
                            <h6 class="dropdown-header">Add Items</h6>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add-destination">Destinations</a>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add-province">Province</a>
                            <div class="dropdown-divider"></div>
                            </div>
                        </div>
                    </div>


                    <?php
                        include '../api/fetch-all-route.php';
                    ?>


                    <div class="row destination-section">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <div class="col-lg-2">
                                <div class="card card-margin">
                                    <div class="card-body pt-0">
                                        <div class="widget-49">
                                            <h5 class="card-title"><?php echo htmlspecialchars($row['from_name']); ?></h5>
                                            <p class="card-text" style="margin-top: -15px;"><?php echo htmlspecialchars($row['province_name']); ?></p>
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
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDestination" data-id="<?php echo htmlspecialchars($destination); ?>" data-from-id="<?php echo htmlspecialchars($from_id); ?>">Delete</button>
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
                                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#destination-modal" data-pickup-id="<?php echo $row['from_id']; ?>">Add</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="widget-49-meeting-action">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="toggleCard(this)">View Drop Location</button>
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
    $(document).ready(function() {
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
$(document).ready(function() {
    // Initialize Select2
    $('.destination-to').select2({
        dropdownParent: $('#destination-modal'),
        width: '100%' // Ensure full width
    });

    // Handle button click to open modal
    $('button[data-bs-toggle="modal"]').on('click', function() {
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
            success: function(data) {
                // Clear existing options
                $('.destination-to').empty();

                // Add options and set disabled status
                data.forEach(function(destination) {
                    var option = new Option(destination.destination_from, destination.from_id, false, false);
                    $(option).prop('disabled', destination.disabled);
                    $('.destination-to').append(option);
                });

                // Refresh Select2 to apply changes
                $('.destination-to').trigger('change');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });
});
</script>


<!--Add Province-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle the click event for the 'Save' button in the modal
    document.querySelector('#add-province .save-province').addEventListener('click', function() {
        // Get the value from the input field
        var provinceName = document.querySelector('input[name="province"]').value.trim();

        // Check if the input is empty
        if (!provinceName) {
            toastr.error('Please enter a province name.');
            return; // Prevent the form from submitting
        }

        // Prepare data to be sent
        var data = {
            province: provinceName
        };

        // Perform AJAX request
        fetch('../api/destination/add-province.php', { // Update the path to your PHP script
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
                $('#add-province').modal('hide'); // Hide the modal
                // Optionally, refresh data or update UI here
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

<!--Fetch Provinces-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.province').select2({
        dropdownParent: $('#add-destination'),
        width: '100%'
    });
    // Function to fetch and display provinces
    function loadProvinces() {
        // Perform AJAX request to fetch provinces
        fetch('../api/destination/fetch-province.php') // Update the path to your PHP script
            .then(response => response.json())
            .then(provinces => {
                const provinceSelect = document.querySelector('.province');

                // Clear any existing options
                provinceSelect.innerHTML = '';

                // Add a default "Select Province" option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '';
                provinceSelect.appendChild(defaultOption);

                // Loop through the provinces and add them as options
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.textContent = province.province;
                    provinceSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching provinces:', error);
            });
    }

    // Load provinces when the page is ready
    loadProvinces();
});
</script>


<!--Save Destination Entry-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the select2 for the province
    $('.province').select2({
        dropdownParent: $('#add-destination'),
        width: '100%'
    });

    // Handle the save button click event
    document.querySelector('.save-destination').addEventListener('click', function() {
        // Get values from the input fields
        var destination = document.querySelector('#destination-input').value;
        var province = document.querySelector('#province-input').value;

        // Check if destination and province have values
        if (!destination || !province) {
            toastr.error('Please fill out all required fields.');
            return;
        }

        // Prepare the data to be sent
        var data = {
            destination: destination,
            province: province
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
                setTimeout(function() {
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
        
        deleteButtons.forEach(function(button) {
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
                        setTimeout(function() {
                            location.reload(); // Refresh the page
                        }, 1000);
                    } else {
                        toastr.error('An error occurred while deleting the destination.');
                        setTimeout(function() {
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