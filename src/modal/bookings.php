<!-- Confirm Delete Modal -->
<div class="modal fade" id="manage-booking" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="confirmDeleteLabel" aria-hidden="true">
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
          <small id="reference-error" class="form-text text-danger d-none">Reference number must start with "RJM-" and
            follow the format RJM-XXXX-XXXXXX.</small>
          <input class="form-control form-control-lg" id="reference-number" type="text" placeholder="RJM-XXXX-XXXXXX">
          <small id="reference-check" class="form-text text-danger d-none">Reference number not found in our
            records.</small>
        </div>

        <div class="form-group">
          <label for="contact-number">Enter Contact Number</label>
          <small id="contact-error" class="form-text text-danger d-none">Contact number should contain exactly 11
            digits.</small>
          <input class="form-control form-control-lg" id="contact-number" type="tel" placeholder="09XXXXXXXXX">
        </div>
      </div>

      <div class="modal-footer border-0 d-flex justify-content-center">
        <button type="button" class="btn btn-danger btn-sm text-light" id="submit-reschedule" disabled>
          <i class="mdi mdi-delete"></i> Submit
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  const referenceInput = document.getElementById("reference-number");
  const contactInput = document.getElementById("contact-number");
  const submitButton = document.getElementById("submit-reschedule");
  let isReferenceValid = false;
  let isContactValid = false;

  // Function to check if both fields are valid to enable the submit button
  function updateSubmitButtonState() {
    submitButton.disabled = !(isReferenceValid && isContactValid);
  }

  // Real-time validation for reference number
  referenceInput.addEventListener("input", function () {
    const referencePattern = /^RJM-\d{4}-\d{6}$/;
    const referenceNumber = this.value;
    const referenceError = document.getElementById("reference-error");
    const referenceCheck = document.getElementById("reference-check");

    if (!referencePattern.test(referenceNumber)) {
      referenceError.classList.remove("d-none");
      referenceCheck.classList.add("d-none");
      isReferenceValid = false;
    } else {
      referenceError.classList.add("d-none");

      // Check if the reference number exists in the database
      $.ajax({
        url: 'src/api/check-reference.php',
        type: 'POST',
        data: { reference_number: referenceNumber },
        success: function (response) {
          try {
            const result = JSON.parse(response);
            console.log("AJAX Success Response:", result);

            if (result.exists) {
              referenceCheck.classList.add("d-none"); // Reference found
              isReferenceValid = true;
            } else {
              referenceCheck.classList.remove("d-none"); // Reference not found
              isReferenceValid = false;
            }
            updateSubmitButtonState();
          } catch (error) {
            console.error("Error parsing JSON response:", error);
            console.log("Raw response:", response);
            isReferenceValid = false;
            updateSubmitButtonState();
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error Status:", status);
          console.error("AJAX Error Thrown:", error);
          console.error("XHR Response Text:", xhr.responseText);
          isReferenceValid = false;
          updateSubmitButtonState();
        }
      });
    }
  });

  // Real-time validation for contact number
  contactInput.addEventListener("input", function () {
    const contactPattern = /^\d{11}$/;
    const contactNumber = this.value;
    const contactError = document.getElementById("contact-error");

    if (!contactPattern.test(contactNumber)) {
      contactError.classList.remove("d-none");
      isContactValid = false;
    } else {
      contactError.classList.add("d-none");
      isContactValid = true;
    }
    updateSubmitButtonState();
  });
</script>




<script>
  $(document).ready(function () {
    $('#submit-reschedule').on('click', function (e) {
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
        success: function (response) {
          var result = JSON.parse(response);
          if (result.success) {
            alert('Reschedule request submitted successfully.');
            $('#manage-booking').modal('hide');
          } else {
            alert('Error: ' + result.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error Status:', status);
          console.log('Error Thrown:', error);
          console.log('XHR Response:', xhr.responseText);
          alert('An error occurred while processing your request. Please check the console for details.');
        }
      });
    });
  });
</script>