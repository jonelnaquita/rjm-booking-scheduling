<!-- Modal -->
<div class="modal fade" id="schedule-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Schedule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Destination From</label>
            <select class="form-control destination-from" name="destination-from">
                <!-- Options will be dynamically added here -->
            </select> 
        </div>

        <div class="form-group">
            <label>Destination To</label>
            <select class="form-control destination-to" name="destination-to">
                <!-- Options will be dynamically added here -->
            </select> 
        </div>

        <div class="row">
            <div class="col">
                <!-- Date Picker -->
                <div class="form-group">
                    <label>Departure Date</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Select Date" id="schedule-datepicker">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Departure Time</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Select Time" id="schedule-timepicker">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="fare">Fare</label>
                <input type="number" class="form-control fare" name="fare" placeholder="₱"></input>
            </div>
        </div>

        <div class="form-group">
            <label>Bus Number</label>
            <select class="form-control bus-number" name="bus-number">
                <!-- Options will be dynamically added here -->
            </select> 
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-schedule">Save</button>
    </div>
    </div>
  </div>
</div>

