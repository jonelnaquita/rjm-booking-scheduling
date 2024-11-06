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
                                    <button type="button" id="profile-tab" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-tabpane" aria-controls="profile-tabpane"
                                        aria-selected="true" class="nav-link active">
                                        Change Email
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button type="button" id="contact-tab" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#contact-tabpane" aria-controls="contact-tabpane"
                                        aria-selected="false" class="nav-link">
                                        Change Password
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="profile-tabpane" aria-labelledby="profile-tab"
                                    class="tab-pane fade show active">
                                    <div class="card-body">
                                        <h4 class="card-title">Change Email</h4>
                                        <p class="card-description">Update your email address</p>
                                        <form class="update-email-form" method="POST" id="update-email-form">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Current Email Address</label>
                                                    <!-- This will be populated dynamically via AJAX -->
                                                    <input type="email" id="current_email" class="form-control"
                                                        name="current_email" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">New Email Address</label>
                                                    <input type="email" id="new_email" class="form-control"
                                                        name="new_email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Enter your password</label>
                                                    <input type="password" id="current_password" class="form-control"
                                                        name="current_password" required>
                                                </div>
                                                <button type="button" id="update_email_btn"
                                                    class="btn btn-primary btn-rounded me-2">Update Email</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- HTML for Change Password Form with Toggle Icons and Validation Message -->
                                <div role="tabpanel" id="contact-tabpane" aria-labelledby="contact-tab"
                                    class="tab-pane fade">
                                    <div class="card-body">
                                        <h4 class="card-title">Change Password</h4>
                                        <p class="card-description">Update your password</p>
                                        <form id="passwordChangeForm" class="forms-sample">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="OldPassword">Current Password</label>
                                                    <div class="input-group">
                                                        <input type="password" id="OldPassword" name="current_password"
                                                            class="form-control" placeholder="Current password"
                                                            required>
                                                        <span class="input-group-text">
                                                            <i class="fa fa-eye toggle-password"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password">New Password</label>
                                                    <div class="input-group">
                                                        <input id="new_password" class="form-control"
                                                            name="new_password" placeholder="New password"
                                                            type="password" required>
                                                        <span class="input-group-text">
                                                            <i class="fa fa-eye toggle-password"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirmPassword">Re-enter Password</label>
                                                    <div class="input-group">
                                                        <input type="password" id="confirmPassword"
                                                            name="confirm_password" class="form-control"
                                                            placeholder="Re-enter password" required>
                                                        <span class="input-group-text">
                                                            <i class="fa fa-eye toggle-password"></i>
                                                        </span>
                                                    </div>
                                                    <small id="message" class="form-text text-muted"></small>
                                                </div>
                                                <button type="button" id="update_password_btn"
                                                    class="btn btn-primary btn-rounded me-2" disabled>Update
                                                    Password</button>
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
    $(document).ready(function () {
        // Fetch the current email on page load
        $.ajax({
            url: '../api/settings/fetch-email.php', // PHP file that fetches the current email
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#current_email').val(response.email); // Populate current email
            },
            error: function (xhr, status, error) {
                toastr.error("Error fetching email: " + error);
            }
        });

        // Handle email update
        $('#update_email_btn').click(function (e) {
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
                success: function (response) {
                    if (response.success) {
                        toastr.success('Email updated successfully!');
                        $('#current_email').val(newEmail); // Update the current email field
                        $('#new_email').val(''); // Clear the new email field
                        $('#current_password').val(''); // Clear the current password field
                    } else {
                        toastr.error(response.message); // Show error message
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error updating email: " + error);
                }
            });
        });
    });
</script>

<!-- jQuery for real-time password validation, matching check, and toggle eye icon -->
<script>
    $(document).ready(function () {
        // Toggle password visibility
        $('.toggle-password').click(function () {
            let input = $(this).closest('.input-group').find('input');
            let type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });

        // Function to validate new password based on requirements
        function validatePassword() {
            let password = $('#new_password').val();
            return password.length >= 8 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[!@#$%^&*]/.test(password);
        }

        // Check if new password and confirm password match and are valid
        function checkPasswordMatch() {
            let newPassword = $('#new_password').val();
            let confirmPassword = $('#confirmPassword').val();
            let message = '';

            if (!validatePassword()) {
                message = 'Password must be at least 8 characters, with uppercase, lowercase, number, and special character.';
                $('#update_password_btn').prop('disabled', true);
                $('#message').css('color', 'red');
            } else if (newPassword !== confirmPassword) {
                message = 'Passwords do not match.';
                $('#update_password_btn').prop('disabled', true);
                $('#message').css('color', 'red');
            } else {
                message = 'Passwords match.';
                $('#update_password_btn').prop('disabled', false);
                $('#message').css('color', 'green');
            }

            $('#message').text(message);
        }

        // Trigger the check when typing in either password field
        $('#new_password, #confirmPassword').on('keyup', checkPasswordMatch);

        // Submit the form via AJAX
        $('#update_password_btn').click(function () {
            let formData = $('#passwordChangeForm').serialize();

            $.ajax({
                type: 'POST',
                url: '../api/settings/update-password.php',
                data: formData,
                success: function (response) {
                    if (response === 'Password updated successfully.') {
                        $('#OldPassword, #new_password, #confirmPassword').val('');
                        $('#message').text('');
                        toastr.success(response);
                    } else {
                        toastr.error(response);
                    }
                },
                error: function () {
                    toastr.error('An error occurred while updating the password.');
                }
            });
        });
    });
</script>

</html>