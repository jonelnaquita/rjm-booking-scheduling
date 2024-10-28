<!-- Confirm Delete Modal -->
<div class="modal fade" id="manage-booking" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 bg-danger">
        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-light" id="confirmDeleteLabel">Manage my bookings</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="reference-number">Enter Reference Number</label>
          <small class="form-text text-muted">You can find it in the email you received.</small>
          <input class="form-control form-control-lg" id="reference-number" type="text" placeholder="RJM-XXXX-XXXXXX-XXXXXX">
        </div>

        <div class="form-group">
          <label for="contact-number">Enter Contact Number</label>
          <small class="form-text text-muted">Number used in your online booking transaction.</small>
          <input class="form-control form-control-lg" id="contact-number" type="tel" placeholder="09XXXXXXXXX">
        </div>
      </div>

      <div class="modal-footer border-0 d-flex justify-content-center">
        <button type="button" class="btn btn-danger btn-sm text-light" id="submit-reschedule">
          <i class="mdi mdi-delete"></i> Submit
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#submit-reschedule').on('click', function(e) {
      e.preventDefault();

      // Get input values
      var referenceNumber = $('#reference-number').val();
      var contactNumber = $('#contact-number').val();

      // Validate if both fields are filled out
      if (referenceNumber === "" || contactNumber === "") {
        alert('Please fill out both the reference number and contact number.');
        return;
      }

      // AJAX request
      $.ajax({
        url: 'src/api/save-reschedule.php', // PHP file to process the request
        type: 'POST',
        data: {
          reference_number: referenceNumber,
          contact_number: contactNumber
        },
        success: function(response) {
          var result = JSON.parse(response);
          if (result.success) {
            alert('Reschedule request submitted successfully.');
            $('#manage-booking').modal('hide');
          } else {
            alert('Error: ' + result.message);
          }
        },
        error: function(xhr, status, error) {
          console.log('Error Status:', status);
          console.log('Error Thrown:', error);
          console.log('XHR Response:', xhr.responseText);
          alert('An error occurred while processing your request. Please check the console for details.');
        }
      });
    });
  });
</script>

