<!-- Modal -->
<div class="modal fade" id="departure-pick-seat" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container mt-5">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div id="seat-grid" class="seat-grid">
                <!-- Seat grid will be dynamically loaded via AJAX -->
              </div>

              <div class="save-button-container">
                <button class="btn btn-primary departure-save-seats" data-bs-dismiss="modal">Save</button>
              </div>
            </div>
          </div>
        </div>

        <div class="seat-status">
          <div class="status-item">
            <span class="color-box booked-seat"></span>
            <label>Booked Seats</label>
          </div>
          <div class="status-item">
            <span class="color-box selected-seat"></span>
            <label>Selected Seats</label>
          </div>
          <div class="status-item">
            <span class="color-box available-seat"></span>
            <label>Available Seats</label>
          </div>
          <div class="status-item">
            <span class="color-box saved-seat"></span>
            <label>Saved Seats</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="arrival-pick-seat" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container mt-5">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div id="seat-grid" class="seat-grid">
                <!-- Seat grid will be dynamically loaded via AJAX -->
              </div>

              <div class="save-button-container">
                <button class="btn btn-primary arrival-save-seats" data-bs-dismiss="modal">Save</button>
              </div>
            </div>
          </div>
        </div>

        <div class="seat-status">
          <div class="status-item">
            <span class="color-box booked-seat"></span>
            <label>Booked Seats</label>
          </div>
          <div class="status-item">
            <span class="color-box selected-seat"></span>
            <label>Selected Seats</label>
          </div>
          <div class="status-item">
            <span class="color-box available-seat"></span>
            <label>Available Seats</label>
          </div>
          <div class="status-item">
            <span class="color-box saved-seat"></span>
            <label>Saved Seats</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
