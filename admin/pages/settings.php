<!DOCTYPE html>
<html lang="en">
<?php
    include '../api/session.php';
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
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
                    <h3 class="tab-title">Settings</h3>
                    
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button type="button"
                                            id="profile-tab"
                                            role="tab" 
                                            data-bs-toggle="tab"
                                            data-bs-target="#profile-tabpane"
                                            aria-controls="profile-tabpane"
                                            aria-selected="true"
                                            class="nav-link active">
                                        Change Email
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button type="button"
                                            id="contact-tab"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#contact-tabpane"
                                            aria-controls="contact-tabpane"
                                            aria-selected="false"
                                            class="nav-link">
                                        Change Password
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button type="button"
                                            id="site-tab"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#site-tabpane"
                                            aria-controls="site-tabpane"
                                            aria-selected="false"
                                            class="nav-link">
                                        Site
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="profile-tabpane"
                                    aria-labelledby="profile-tab" 
                                    class="tab-pane fade show active">
                                    <div class="card-body">
                                        <h4 class="card-title">Change Email</h4>
                                        <p class="card-description">Update your email address</p>
                                        <form class="update-email-form" method="POST" id="update-email-form">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Current Email Address</label>
                                                    <!-- This will be populated dynamically via AJAX -->
                                                    <input type="email" id="current_email" class="form-control" name="current_email" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">New Email Address</label>
                                                    <input type="email" id="new_email" class="form-control" name="new_email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Enter your password</label>
                                                    <input type="password" id="current_password" class="form-control" name="current_password" required>
                                                </div>
                                                <button type="button" id="update_email_btn" class="btn btn-danger me-2">Update Email</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <div role="tabpanel" id="contact-tabpane"
                                    aria-labelledby="contact-tab" 
                                    class="tab-pane fade">
                                    <!-- Content for Change Password -->
                                    <div class="card-body">
                                        <h4 class="card-title">Change Password</h4>
                                        <p class="card-description">Update your password</p>
                                        <form id="passwordChangeForm" class="forms-sample">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="OldPassword">Current Password</label>
                                                    <input type="password" id="OldPassword" name="current_password" class="form-control" placeholder="Current password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password">New Password</label>
                                                    <input id="new_password" class="form-control" name="new_password" placeholder="New password" type="password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirmPassword">Re-enter your password</label>
                                                    <input type="password" id="confirmPassword" name="confirm_password" class="form-control" placeholder="Re-enter password" required>
                                                    <!-- Validation message -->
                                                    <small id="message" class="form-text text-muted"></small>
                                                </div>
                                                <button type="button" id="update_password_btn" class="btn btn-danger me-2" disabled>Update Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div role="tabpanel" id="site-tabpane" aria-labelledby="site-tab" class="tab-pane fade">
                                    <!-- Content for Change Email -->
                                    <div class="card-body">
                                        <h4 class="card-title">Website Settings</h4>
                                        <p class="card-description">Update website details.</p>
                                        <form id="site-settings-form" class="forms-sample" method="POST" enctype="multipart/form-data">
                                            <div class="col-md-6">

                                                <!-- Fetch and display existing settings -->
                                                <?php
                                                include '../api/settings/fetch-site-details.php';
                                                ?>

                                                <div class="form-group">
                                                    <label for="company_name">Company Name</label>
                                                    <input type="text" id="company_name" class="form-control" name="company_name" value="<?php echo htmlspecialchars($company_name); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="logo">Logo</label>
                                                    
                                                    <!-- Display the current logo if available -->
                                                    <div id="current-logo" style="margin-bottom: 10px;">
                                                        <?php if ($logo_path): ?>
                                                            <img id="current-logo-img" src="../assets/images/<?= htmlspecialchars($logo_path) ?>" alt="Current Logo" style="width: 100px; height: auto;">
                                                        <?php else: ?>
                                                            <p>No logo uploaded.</p>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Preview for the new selected logo -->
                                                    <div id="preview-container" style="margin-bottom: 10px; display: none;">
                                                        <p>Preview:</p>
                                                        <img id="logo-preview" src="" alt="Image Preview" style="width: 100px; height: auto;">
                                                    </div>
                                                    
                                                    <!-- File input for new logo -->
                                                    <input type="file" id="logo" name="logo" class="form-control" accept=".jpg, .jpeg, .png, .svg">
                                                    
                                                    <!-- Error message for invalid file format -->
                                                    <small id="file-error" class="form-text text-danger"></small>

                                                    <!-- Hidden field to store the current logo path -->
                                                    <input type="hidden" name="current_logo_path" value="<?php echo htmlspecialchars($logo_path); ?>">
                                                </div>

                                                <button type="button" id="update_site_btn" class="btn btn-danger me-2">Update Website</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>


            <!--Include Footer -->
            <?php
                include '../components/footer.php';
            ?>

            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</body>

<!--Change Email-->
<script>
$(document).ready(function() {
    // Fetch the current email on page load
    $.ajax({
        url: '../api/settings/fetch-email.php', // PHP file that fetches the current email
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#current_email').val(response.email); // Populate current email
        },
        error: function(xhr, status, error) {
            toastr.error("Error fetching email: " + error);
        }
    });

    // Handle email update
    $('#update_email_btn').click(function(e) {
        e.preventDefault();
        const newEmail = $('#new_email').val();
        const currentPassword = $('#current_password').val();

        $.ajax({
            url: '../api/settings/update-email.php', // PHP file that handles the email update
            method: 'POST',
            data: {
                new_email: newEmail,
                current_password: currentPassword
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success('Email updated successfully!');
                    $('#current_email').val(newEmail); // Update the current email field
                    $('#new_email').val(''); // Clear the new email field
                    $('#current_password').val(''); // Clear the current password field
                } else {
                    toastr.error(response.message); // Show error message
                }
            },
            error: function(xhr, status, error) {
                console.log("Error updating email: " + error);
            }
        });
    });
});
</script>

<!-- jQuery for real-time password match check and form submission -->
<script>
    $(document).ready(function() {
        // Function to check if new password and confirm password match
        function checkPasswordMatch() {
            let newPassword = $('#new_password').val();
            let confirmPassword = $('#confirmPassword').val();
            let message = '';

            if (newPassword === confirmPassword) {
                message = 'Passwords match.';
                $('#update_password_btn').prop('disabled', false); // Enable the button
                $('#message').css('color', 'green');
            } else {
                message = 'Passwords do not match.';
                $('#update_password_btn').prop('disabled', true); // Disable the button
                $('#message').css('color', 'red');
            }

            $('#message').text(message);
        }

        // Trigger the check when typing in either password field
        $('#new_password, #confirmPassword').on('keyup', function() {
            checkPasswordMatch();
        });

        // Submit the form via AJAX
        $('#update_password_btn').click(function() {
            var formData = $('#passwordChangeForm').serialize();

            $.ajax({
                type: 'POST',
                url: '../api/settings/update-password.php', // Update this path to your PHP file
                data: formData,
                success: function(response) {
                    if (response === 'Password updated successfully.') {
                        $('#OldPassword').val('');
                        $('#new_password').val('');
                        $('#confirmPassword').val('');
                        toastr.success('Password updated successfully.');
                    } else if (response === 'The current password is incorrect.') {
                        toastr.error('The current password is incorrect.');
                    } else {
                        toastr.error('Error updating password.');
                    }
                },
                error: function() {
                    toastr.error('An error occurred while updating the password.');
                }
            });
        });
    });
</script>

<script>
$(document).ready(function () {
    $('#logo').change(function (e) {
        let file = this.files[0];
        let fileType = file.type;
        let validExtensions = ['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml'];
        let fileError = $('#file-error');
        let previewContainer = $('#preview-container');
        let logoPreview = $('#logo-preview');

        // Check if the file type is valid
        if (!validExtensions.includes(fileType)) {
            fileError.text('Invalid file format. Please upload a JPG, JPEG, PNG, or SVG file.');
            $(this).val('');  // Clear the file input
            previewContainer.hide(); // Hide the preview
        } else {
            fileError.text('');  // Clear the error message
            
            // Display the preview
            let reader = new FileReader();
            reader.onload = function (e) {
                logoPreview.attr('src', e.target.result);  // Set the preview image src
                previewContainer.show();  // Show the preview container
            }
            reader.readAsDataURL(file); // Read the file to get the Data URL for preview
        }
    });

    $('#update_site_btn').click(function () {
    // Create a FormData object to handle the form data
    let formData = new FormData($('#site-settings-form')[0]);

    $.ajax({
        url: '../api/settings/update-site-details.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            // Handle the success response from the server
            toastr.success(response);

            // Add the 'show active' class to the site-tab and reload the page after 1 second
            setTimeout(function () {
                $('#site-tabpane').addClass('show active');
                location.reload();
            }, 1000); // 1000 milliseconds = 1 second
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle any errors that occur during the AJAX request
            toastr.error('An error occurred while updating the website settings.');
        }
    });
});

});

</script>


</html>