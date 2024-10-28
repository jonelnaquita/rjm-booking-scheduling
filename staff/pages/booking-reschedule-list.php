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
                    <h3 class="tab-title">Cancelled Bookings</h3>
                    <div class="table-responsive ">
                            <table id="reschedule-table" class="table table-data2 nowrap dt-responsive w-100" style="margin-top: 20px; margin-bottom: 20px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Book ID</th>
                                        <th>Contact Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include '../api/booking/fetch-booking-reschedule.php';
                                    ?>
                                </tbody>
                            </table>
                        </div>
                </div>


            <!--Include Footer -->
            <?php
                include '../components/footer.php';
                include '../modal/booking-modal.php';
            ?>

            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</body>

<script>
    $(document).ready(function(){
        var table = $('#reschedule-table').DataTable({
            "aLengthMenu": [[10, 25, -1], [10, 25, 50, "All"]],
            "iDisplayLength": 10
        });
    })
</script>

<script>
  $(document).ready(function() {
    var rescheduleId;

    // When the "Done" button is clicked, get the data-book-id
    $('#reschedule-status').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      rescheduleId = button.data('book-id'); // Extract reschedule ID from data-* attribute
    });

    // Handle the confirm button click inside the modal
    $('#submit-reschedule').on('click', function(e) {
      e.preventDefault();

      // AJAX request to update the status
      $.ajax({
        url: '../api/booking/update-reschedule-status.php', // PHP file to handle the request
        type: 'POST',
        data: { reschedule_id: rescheduleId },
        success: function(response) {
          var result = JSON.parse(response);
          if (result.success) {
            toastr.success('Status updated to Done successfully.', 'Success');
            $('#reschedule-status').modal('hide');
            setTimeout(function() {
              location.reload();
            }, 1000); // 1 second delay
          } else {
            alert('Error: ' + result.message);
          }
        },
        error: function(xhr, status, error) {
          toastr.error('An error occurred while processing your request. Please check the console for details.');
          setTimeout(function() {
            location.reload();
        }, 1000);
        }
      });
    });
  });
</script>





</html>