<!-- Modal -->
<div class="modal fade" id="schedule-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-0 bg-light add-header">
        <i class="mdi mdi-plus-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-danger" id="confirmDeleteLabel">Add New Schedule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-header border-0 bg-light d-none update-header">
        <i class="mdi mdi-pencil-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-danger" id="confirmDeleteLabel">Update Schedule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Bus Number</label>
          <select class="form-control bus-number" name="bus-number">
            <!-- Options will be dynamically added here -->
          </select>
        </div>

        <div class="form-group">
          <input type="hidden" class="form-control destination-from" name="destination-from">
        </div>

        <div class="form-group">
          <input type="hidden" class="form-control destination-to" name="destination-to">
        </div>

        <div class="row">
          <div class="col">
            <!-- Date Picker -->
            <div class="form-group">
              <label>Departure Date</label>
              <input type="text" class="form-control form-control-sm" placeholder="Select Date"
                id="schedule-datepicker">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Departure Time</label>
              <input type="text" class="form-control form-control-sm" placeholder="Select Time"
                id="schedule-timepicker">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-group">
            <label for="fare">Fare</label>
            <input type="number" class="form-control fare" name="fare" placeholder="₱"></input>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 d-flex justify-content-center">
        <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-rounded save-schedule">
          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
          Save
        </button>
        <button type="button" class="btn btn-primary btn-rounded edit-schedule d-none">
          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
          Save
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirm-delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 bg-light">
        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-danger" id="confirmDeleteLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">Are you sure you want to delete this item? This action cannot be undone.</p>
      </div>
      <div class="modal-footer border-0 d-flex justify-content-center">
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
          <i class="mdi mdi-cancel"></i> Cancel
        </button>
        <!-- Add 'id="confirm-delete-btn"' to target the delete button for AJAX -->
        <button type="button" class="btn btn-danger btn-sm text-light" id="confirm-delete-btn">
          <i class="mdi mdi-delete"></i> Delete
        </button>
      </div>
    </div>
  </div>
</div>