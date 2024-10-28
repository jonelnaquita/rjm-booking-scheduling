<!DOCTYPE html>
<html lang="en">
<?php
    include '../api/session.php';
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
    <link rel="stylesheet" href="../assets/css/staff.css">

    <style>
        .is-invalid {
            border-color: #dc3545; /* Bootstrap's red border color for invalid fields */
        }

        .nav-pills .nav-link.active {
            background-color: #de5108; /* Bootstrap's blue color for active tab */
            color: #fff; /* Text color for active tab */
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
                    <h3 class="tab-title">Manage Staff</h3>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#staff-modal">
                                <i class="ti-plus btn-icon-prepend"></i> Add Staff
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Staff List</h4>
                            <div class="row">
                                <div class="col-md-10 mx-auto">
                                <ul class="nav nav-pills nav-pills-custom" id="pills-tab-custom" role="tablist">
                                    <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-home-tab-custom" data-bs-toggle="pill" href="#terminal-staff-tab" role="tab" aria-controls="pills-home" aria-selected="true">
                                        Terminal Staffs
                                    </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-profile-tab-custom" data-bs-toggle="pill" href="#drivers-tab" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">
                                        Drivers
                                    </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-contact-tab-custom" data-bs-toggle="pill" href="#conductors-tab" role="tab" aria-controls="pills-contact" aria-selected="false" tabindex="-1">
                                        Conductors
                                    </a>
                                    </li>
                                </ul>
                                <div class="tab-content tab-content-custom-pill" id="pills-tabContent-custom">
                                    <div class="tab-pane fade active show" id="terminal-staff-tab" role="tabpanel" aria-labelledby="pills-home-tab-custom">
                                        <div class="container mt-4">
                                            <div class="row" id="terminal-staff">
                                                <!-- Cards for Terminal Staff will be dynamically added here -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="drivers-tab" role="tabpanel" aria-labelledby="pills-profile-tab-custom">
                                        <div class="container mt-4">
                                            <div class="row" id="drivers">
                                                <!-- Cards for Drivers will be dynamically added here -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="conductors-tab" role="tabpanel" aria-labelledby="pills-contact-tab-custom">
                                        <div class="container mt-4">
                                            <div class="row" id="conductors">
                                                <!-- Cards for Conductors will be dynamically added here -->
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="row">
                        
                    </div>


                </div>


            <!--Include Footer -->
            <?php
                include '../modal/staff-modal.php';
                include '../components/footer.php';
            ?>

            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</body>

<script>
$(document).ready(function() {
    // Initialize Select2 with custom options
    $('#role').select2({
        dropdownParent: $('#staff-modal'),
        width: '100%' // Ensure full width
    });

    $('#role-2').select2({
        dropdownParent: $('#edit-staff-modal'),
        width: '100%' // Ensure full width
    });
    
    $('#terminal').select2({
        dropdownParent: $('#staff-modal'),
        width: '100%' // Ensure full width
    });

    $('#terminal-2').select2({
        dropdownParent: $('#edit-staff-modal'),
        width: '100%' // Ensure full width
    });

    $('#bus_number').select2({
        dropdownParent: $('#staff-modal'),
        width: '100%' // Ensure full width
    });

    $('#bus_number-2').select2({
        dropdownParent: $('#edit-staff-modal'),
        width: '100%' // Ensure full width
    });

        // Populate role
        $('#role').append(new Option('Select Role', '', true, true)).prop('selected', true);
        $('#role').append(new Option('Terminal Staff', 'Terminal Staff'));
        $('#role').append(new Option('Driver', 'Driver'));
        $('#role').append(new Option('Conductor', 'Conductor'));
        $('#role').val('').trigger('change');

        $('#role-2').append(new Option('Select Role', '', true, true)).prop('selected', true);
        $('#role-2').append(new Option('Terminal Staff', 'Terminal Staff'));
        $('#role-2').append(new Option('Driver', 'Driver'));
        $('#role-2').append(new Option('Conductor', 'Conductor'));
        $('#role-2').val('').trigger('change');


    // Fetch terminals and bus numbers from server
    $.ajax({
        url: '../api/staff/fetch-terminal.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Populate terminal select
            $('#terminal').empty().append('<option value="" disabled selected>Select Terminal</option>');
            $.each(data.terminals, function(index, terminal) {
                $('#terminal').append(`<option value="${terminal.from_id}">${terminal.destination_from}</option>`);
            });

            $('#terminal-2').empty().append('<option value="" disabled selected>Select Terminal</option>');
            $.each(data.terminals, function(index, terminal) {
                $('#terminal-2').append(`<option value="${terminal.from_id}">${terminal.destination_from}</option>`);
            });

            // Populate bus number select
            $('#bus_number').empty().append('<option value="" disabled selected>Select Bus Number</option>');
            $.each(data.buses, function(index, bus) {
                $('#bus_number').append(`<option value="${bus.bus_id}">${bus.bus_number}</option>`);
            });

            $('#bus_number-2').empty().append('<option value="" disabled selected>Select Bus Number</option>');
            $.each(data.buses, function(index, bus) {
                $('#bus_number-2').append(`<option value="${bus.bus_id}">${bus.bus_number}</option>`);
            });
        },
        error: function() {
            console.log('Error fetching options');
        }
    });
});
</script>

<!-- Show Bus Number based on Role -->
<script>
    $(document).ready(function () {
    // Initialize the bus number field as hidden
    $('#bus_number').closest('.form-group').hide();
    $('#bus_number-2').closest('.form-group').hide();

    // Role change event listener
    $('#role').change(function () {
        let selectedRole = $(this).val();

        if (selectedRole === 'Driver' || selectedRole === 'Conductor') {
            // Show the bus number field if the role is Driver or Conductor
            $('#bus_number').closest('.form-group').show();
        } else {
            // Hide the bus number field if the role is Terminal Staff or other
            $('#bus_number').closest('.form-group').hide();
        }
    });

    $('#role-2').change(function () {
        let selectedRole = $(this).val();

        if (selectedRole === 'Driver' || selectedRole === 'Conductor') {
            // Show the bus number field if the role is Driver or Conductor
            $('#bus_number-2').closest('.form-group').show();
        } else {
            // Hide the bus number field if the role is Terminal Staff or other
            $('#bus_number-2').closest('.form-group').hide();
        }
    });
});
</script>

<script>
    function validateFormAndSave() {
    let isValid = true;
    
    // Check if all required fields have values
    $('#userForm input[required], #userForm select[required]').each(function() {
        if ($(this).val().trim() === '') {
            isValid = false;
            $(this).addClass('is-invalid'); // Add a class to highlight invalid fields
        } else {
            $(this).removeClass('is-invalid'); // Remove class if field is valid
        }
    });

    // Check if email is provided and if it's valid
    let email = $('#email').val().trim();
    if (email === '') {
        $('#email-error').hide(); // Hide the email error message if no email
    } else {
        $('#email-error').show(); // Show the email error message if email is not empty
    }

    if (isValid) {
        // Proceed with AJAX call if form is valid
        let formData = new FormData($('#userForm')[0]);

        $.ajax({
            url: '../api/staff/save-staff.php', // PHP script that handles form submission
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Display success message or perform any action based on the response
                toastr.success(response);
                
                // Clear all form fields
                $('#userForm')[0].reset();
                $('#role').val(null).trigger('change'); // Reset select2 fields
                $('#terminal').val(null).trigger('change'); // Reset select2 fields
                $('#bus_number').val(null).trigger('change'); // Reset select2 fields
                $('#email-error').hide();

                $('#staff-modal').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle error
                toastr.error('Error saving staff. Please try again.');
            }
        });
    } else {
        toastr.error('Please fill out all required fields.');
    }
}

// Bind the function to the Save button click event
$('.save-staff').click(function(e) {
    e.preventDefault();
    validateFormAndSave();
});

// Optional: Enable the save button only when the form is valid
$('#userForm input, #userForm select').on('input change', function() {
    let isFormValid = $('#userForm')[0].checkValidity();
    $('.save-staff').prop('disabled', !isFormValid);
});

</script>


<!-- Check Email -->
<script>
$(document).ready(function () {
    $('#email-error').hide();
    $('#email').on('input', function () {
        var email = $(this).val();

        if (email !== '') {
            $.ajax({
                url: '../api/staff/check-email.php', // The PHP file to check email
                type: 'POST',
                data: { email: email },
                success: function (response) {
                    console.log('Server response:', response); // Debugging
                    if (response.trim() === 'taken') {  // Check if the response indicates the email is taken
                        // If the email is already taken, show the error message
                        $('#email-error').show();
                        $('.save-staff').prop('disabled', true); // Disable the save button
                    } else {
                        // If the email is not taken, hide the error message
                        $('#email-error').hide();
                        $('.save-staff').prop('disabled', false); // Enable the save button
                    }

                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error); // Log any AJAX errors
                }
            });
        } else {
            // Hide the error message if the email field is empty
            $('#email-error').hide();
        }
    });
});
</script>


<script>
$(document).ready(function() {
    function fetchStaffData() {
        $.ajax({
            url: '../api/staff/fetch-staff.php', // Adjust the path to your PHP file
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Clear existing content
                $('#terminal-staff').empty();
                $('#drivers').empty();
                $('#conductors').empty();

                // Populate the container based on the role
                data.forEach(function(staff) {
                    // Create a base card template
                    var card = `
                        <div class="col-md-6 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div>
                                        <h3 class="staff-name">${staff.firstname} ${staff.lastname}</h3>
                                        <p class="staff-role">${staff.role}</p>
                                        <p class="email">${staff.email}</p>
                                        <h6 class="terminal mt-3">${staff.destination_from} Terminal</h6>
                                        ${staff.role === 'Driver' || staff.role === 'Conductor' ? `<h6 class="bus-number">Bus #: ${staff.bus_number}</h6>
                                        <h6 class="bus-type">${staff.bus_type}</h6>` : ''}
                                    </div>
                                    <button class="btn btn-info btn-sm mt-3 mb-4 text-light" update-data-id="${staff.staff_id}" data-bs-toggle="modal" data-bs-target="#edit-staff-modal">Update</button>
                                    <button class="btn btn-danger btn-sm mt-3 mb-4 text-light" delete-data-id="${staff.staff_id}" data-bs-toggle="modal" data-bs-target="#delete-staff-modal">Delete</button>
                                </div>
                            </div>
                        </div>`;

                    // Append the card to the appropriate tab based on the role
                    if (staff.role === 'Terminal Staff') {
                        $('#terminal-staff').append(card);
                    } else if (staff.role === 'Driver') {
                        $('#drivers').append(card);
                    } else if (staff.role === 'Conductor') {
                        $('#conductors').append(card);
                    }
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching staff data:', textStatus, errorThrown);
            }
        });
    }

    // Fetch data initially
    fetchStaffData();

    // Optionally, set up a mechanism to refresh data periodically (e.g., every 30 seconds)
    setInterval(fetchStaffData, 1000); // Adjust the interval as needed
});
</script>


<!--Update Staff-->
<script>
    $(document).on('click', '.btn-info', function() {
    // Get the staff ID from the button's attribute
    var staff_id = $(this).attr('update-data-id');
    
    // Make an AJAX request to get the staff details based on staff_id
    $.ajax({
        url: '../api/staff/fetch-existing-staff.php', // PHP file to fetch staff details
        type: 'POST',
        data: { staff_id: staff_id },
        dataType: 'json',
        success: function(response) {
            // Populate the input fields with the existing details
            $('#firstname-2').val(response.firstname);
            $('#lastname-2').val(response.lastname);
            $('#role-2').val(response.role).trigger('change');
            $('#terminal-2').val(response.terminal).trigger('change');
            $('#bus_number-2').val(response.bus_number).trigger('change');
            
            // Set the staff_id to a hidden field or use it when submitting the form
            $('#edit-staff-modal').data('staff-id', staff_id);
        },
        error: function(xhr, status, error) {
            alert('Failed to fetch staff details: ' + error);
        }
    });
});
</script>

<script>
    $('.edit-staff-btn').click(function() {
    // Get the staff_id stored in the modal
    var staff_id = $('#edit-staff-modal').data('staff-id');

    // Collect the form data
    var formData = {
        staff_id: staff_id,
        firstname: $('#firstname-2').val(),
        lastname: $('#lastname-2').val(),
        role: $('#role-2').val(),
        terminal: $('#terminal-2').val(),
        bus_number: $('#bus_number-2').val()
    };

    // AJAX request to update the staff details
    $.ajax({
        url: '../api/staff/update-staff.php', // PHP file to handle the update
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response === 'success') {
                toastr.success('Staff details updated successfully.');
                $('#edit-staff-modal').modal('hide');
                fetchStaffData();
            } else {
                toastr.error('Failed to update staff details. Try again.');
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
});
</script>


<!-- Delete Staff -->
<script>
$(document).on('click', '.btn-danger', function() {
    var staff_id = $(this).attr('delete-data-id');
    $('.staff_id').val(staff_id);
});

$('#confirm-delete').click(function() {
    var staff_id = $('.staff_id').val(); // Get the staff ID

    // AJAX request to delete the staff
    $.ajax({
        url: '../api/staff/delete-staff.php', // PHP file to handle the deletion
        type: 'POST',
        data: { staff_id: staff_id },
        success: function(response) {
            if (response === 'success') {
                toastr.success('Staff has been deleted successfully.');
                $('#delete-staff-modal').modal('hide');
                fetchStaffData();
            } else {
                toastr.error('Failed to delete staff. Try again.');
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
});
</script>



</html>