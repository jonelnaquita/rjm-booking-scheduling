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
                include '../components/sidebar-driver.php';
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
                                                <button type="button" id="update_email_btn" class="btn btn-primary btn-rounded me-2">Update Email</button>
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
                                                <button type="button" id="update_password_btn" class="btn btn-primary btn-rounded me-2" disabled>Update Password</button>
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


</html>