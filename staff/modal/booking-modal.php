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
        <div class="alert alert-confirmation">
          <i class="fa fa-exclamation-circle"></i><br>
          <div class="alert-content">
            <span class="swal-title">Do you want to confirm this booking?</span><br>
            <!--<span class="passenger-id"></span>-->
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-rounded btn-fw" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="confirm-btn btn btn-primary btn-rounded btn-fw" id="confirmBooking">
          Confirm
        </button>
      </div>
    </div>
  </div>
</div>



<!--Cancel Booking-->
<div class="modal fade" id="cancel-booking-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Cancel Booking</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-rounded text-light" data-bs-toggle='modal' data-bs-target='#confirm-cancel-modal'>Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirm-cancel-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden" class="form-control booking-id" name="booking_id">
        <input type="hidden" class="form-control cancel-reason" name="cancel_reason">

        <!-- Alert Message -->
        <div class="alert alert-confirmation">
            <i class="fa fa-exclamation-circle"></i><br>
            <div class="alert-content">
                <span class="swal-title">Do you want to cancel this booking?</span><br>
                <!--<span class="passenger-id"></span>-->
            </div>
        </div>

      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-light btn-rounded btn-fw" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="confirm-btn btn btn-primary btn-rounded btn-fw" id="confirmCancel">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- Re-schedule Modal -->
<div class="modal fade" id="reschedule-status" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 bg-light">
        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-danger" id="confirmDeleteLabel">Confirm Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">Are you sure you want to confirm this status? This action cannot be undone.</p>
      </div>

      <div class="modal-footer border-0 d-flex justify-content-center">
        <button type="button" class="btn btn-danger btn-sm text-light" id="submit-reschedule">Confirm</button>
      </div>
    </div>
  </div>
</div>


<!-- Re-schedule Booking Modal -->
<div class="modal fade" id="reschedule-booking" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 bg-light">
        <i class="mdi mdi-pencil-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-danger" id="confirmDeleteLabel">Re-schedule Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal Body for Rescheduling -->
      <div class="modal-body">
        <input type="hidden" class="form-control form-control-sm" id="booking-id">
        <input type="hidden" class="form-control form-control-sm" id="passenger-count">
        <div class="row">
          <div class="col departure-card">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                      <i class="mdi mdi-map-marker mdi-24px text-primary"></i> 
                      <span class="fw-bold">Departure: </span>
                      <span class="text-muted" id="departure-destination-text">[Departure Destination]</span>
                  </div>
                  
                  <div>
                      <i class="mdi mdi-arrow-right-bold mdi-24px text-secondary"></i>
                  </div>
                  
                  <div>
                      <i class="mdi mdi-map-marker mdi-24px text-success"></i> 
                      <span class="fw-bold">Arrival: </span>
                      <span class="text-muted" id="arrival-destination-text">[Arrival Destination]</span>
                  </div>
              </div>

              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" class="form-control form-control-sm" id="departure-destination-from">
                  <input type="hidden" class="form-control form-control-sm" id="departure-destination-to">
                  <input type="hidden" class="form-control form-control-sm" id="departure-bus">
                  <input type="hidden" class="form-control form-control-sm" id="departure-schedule-id">
                  <input type="hidden" class="form-control form-control-sm" id="departure-seat-number">
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Departure Date</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Select Date" id="departure-datepicker">
                  </div>
                </div>
                
                <div class="row">
                    <div class="col-12 schedules" style="max-height: 300px;">
                        <div class="table-responsive custom-table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Class</th>
                                        <th scope="col">Available Seats</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="schedule-table-body">
                                    <!-- Schedule rows will be injected here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="seat-btn text-center" style="margin-top: 50px;">
                  <button class="btn pick-seat-btn btn-primary">Pick Seat</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Arrival Card (Hidden if One-Way Trip) -->
          <div class="col arrival-card" style="display: none;">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                      <i class="mdi mdi-map-marker mdi-24px text-primary"></i> 
                      <span class="fw-bold">Departure: </span>
                      <span class="text-muted" id="departure-destination-text2">[Departure Destination]</span>
                  </div>
                  
                  <div>
                      <i class="mdi mdi-arrow-right-bold mdi-24px text-secondary"></i>
                  </div>
                  
                  <div>
                      <i class="mdi mdi-map-marker mdi-24px text-success"></i> 
                      <span class="fw-bold">Arrival: </span>
                      <span class="text-muted" id="arrival-destination-text2">[Arrival Destination]</span>
                  </div>
              </div>
              <div class="card-body">
                <div class="col">
                  <div class="form-group">
                    <input type="hidden" class="form-control form-control-sm" id="arrival-destination-from">
                    <input type="hidden" class="form-control form-control-sm" id="arrival-destination-to">
                    <input type="hidden" class="form-control form-control-sm" id="arrival-bus">
                    <input type="hidden" class="form-control form-control-sm" id="arrival-schedule-id">
                    <input type="hidden" class="form-control form-control-sm" id="arrival-seat-number">
                  </div>
                  <div class="form-group">
                    <label>Arrival Date</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Select Date" id="arrival-datepicker">
                  </div>
                </div>
                
                <div class="row">
                    <div class="col-12 schedules" style="max-height: 300px;">
                        <div class="table-responsive custom-table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Class</th>
                                        <th scope="col">Available Seats</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="arrival-table-body">
                                    <!-- Arrival schedule rows will be injected here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="seat-btn text-center" style="margin-top: 50px;">
                  <button class="btn arrival-pick-seat-btn btn-primary">Pick Seat</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer border-0 d-flex justify-content-center">
        <button type="button" class="btn btn-danger btn-md btn-rounded text-light submit-reschedule">Confirm</button>
        <button type="button" class="btn btn-light btn-md btn-rounded text-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>