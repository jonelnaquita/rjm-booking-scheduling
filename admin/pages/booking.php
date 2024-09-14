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
    <link rel="stylesheet" href="../assets/css/booking.css">

<script>

$(document).ready(function() {
    $('#table-example').DataTable({     
        "aLengthMenu": [[10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 10
        } 
    );
    });
</script>

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
                    <h3 class="tab-title">Bookings</h3>

                        <div class="table-responsive ">
                            <table id="table-example" class="table table-data2 nowrap dt-responsive w-100" style="margin-top: 20px; margin-bottom: 20px;">
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include '../api/booking/fetch-booking-list.php';
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                </div>


            <!--Include Footer -->
            <?php
                include '../components/footer.php';
                include '../modal/booking-modal.php';
            ?>

            </div>
        </div>
    </div>
</body>


<script>
$(document).on('click', '.btn-accept', function() {
    // Get the booking ID from the data-book-id attribute
    var book_id = $(this).data('book-id');

    // Log the booking ID to ensure it's being retrieved correctly
    console.log('Booking ID:', book_id);

    // Send AJAX request to fetch payment details
    $.ajax({
        url: '../api/booking/get-payment-details.php', // Adjust path to your API
        type: 'POST',
        data: { book_id: book_id },
        dataType: 'json',
        success: function(response) {
            console.log('AJAX response:', response); // Log the response to check the data

            if (response.success) {
                // Populate the modal with the fetched details
                var modalBody = `
                    <h2 class="modal-total-amount">Total Amount: ₱${response.data.price}</h2>
                    <h5 class="modal-reference-number">Reference Number: ${response.data.reference_number}</h5>
                    <img src="../../src/payment/${response.data.screenshot_filename}" alt="Screenshot" class="modal-screenshot img-fluid" />
                `;
                $('#accept-booking-modal .modal-body').html(modalBody);

                $('#confirm-booking-modal .booking_id').val(book_id);
                $('#confirm-booking-modal .passenger-id').html(book_id);
            } else {
                alert('No payment details found.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Log the full error details for debugging
            console.error('Error fetching payment details:', textStatus, errorThrown);
            console.log('Response text:', jqXHR.responseText);
        }
    });
});

</script>

<!-- Confirm Booking -->
<script>
    $('#confirmBooking').on('click', function() {
        let bookingId = $('.booking_id').val(); // Get the booking ID

        $.ajax({
            url: '../api/booking/confirm-booking.php',  // Point to your PHP file for sending email
            type: 'POST',
            data: { booking_id: bookingId },
            success: function(response) {
                // Close the modal
                $('#confirm-booking-modal').modal('hide');

                // Show a toastr success message
                toastr.success('Booking confirmed and e-ticket sent successfully!', 'Success');
                location.reload();
            },
            error: function() {
                // Close the modal in case of error
                $('#confirm-booking-modal').modal('hide');

                // Show an error toastr message
                toastr.error('An error occurred. Please try again.', 'Error');
            }
        });
    });
</script>



</html>