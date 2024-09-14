<div class="modal fade" id="accept-booking-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="accept-booking-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <!-- The payment details will be loaded here via AJAX -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-rounded btn-fw" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-rounded btn-fw" data-bs-toggle='modal' data-bs-target='#confirm-booking-modal'>Confirm</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirm-booking-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden" class="form-control booking_id" name="booking_id">

        <!-- Alert Message -->
        <!-- Alert Message -->
        <div class="alert alert-confirmation">
            <i class="fa fa-exclamation-circle"></i><br>
            <div class="alert-content">
                <span class="swal-title">Do you want to confirm this booking?</span><br>
                <span class="passenger-id"></span>
            </div>
        </div>

      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-light btn-rounded btn-fw" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="confirm-btn btn btn-primary btn-rounded btn-fw" id="confirmBooking">Confirm</button>
      </div>
    </div>
  </div>
</div>
