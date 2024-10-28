<!-- Add Bus Type Modal -->
<div class="modal fade" id="bus-type" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Bus Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="bus-type-id"></input>
        <div class="form-group">
          <label>Bus Type</label>
          <input type="text" class="form-control form-control-sm" name="bus-type" placeholder="Add Bus Type" required>
        </div>

        <div class="form-group">
          <label>Bus Description</label>
          <textarea class="form-control form-control-sm" name="description" required style="height: 100px;"></textarea>
        </div>

        <div class="table-responsive">
            <table class="table table-bus-type">
                <thead>
                    <tr>
                        <th>Bus Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamically loaded content -->
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info save-bus-type" disabled>Save</button>
        <button type="submit" class="btn btn-primary add-bus-type" disabled>Add</button>
      </div>
    </div>
  </div>
</div>


<!-- Add New Bus Modal -->
<div class="modal fade" id="new-bus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0 bg-light add-header">
        <i class="mdi mdi-plus-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-danger" id="confirmDeleteLabel">Add New Bus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="form-group">
            <label>Bus Number</label>
            <input type="text" class="form-control form-control-sm" name="bus-number" placeholder="Enter Bus Number" required>
          </div>
        </div>
        
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Bus Type</label>
                <select class="form-select" id="bus-type-id" required>
                    <!-- Bus types will be dynamically loaded here -->
                </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Bus Seats</label>
              <input type="number" class="form-control form-control-sm" name="bus-seats" placeholder="Enter Bus Number" required>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add-new-bus" disabled>Add</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Bus -->
<div class="modal fade" id="update-bus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0 bg-light add-header">
        <i class="mdi mdi-pencil-circle-outline mdi-48px text-danger me-2"></i>
        <h5 class="modal-title text-danger" id="confirmDeleteLabel">Update Bus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="form-group">
            <label>Bus Number</label>
            <input type="text" class="form-control form-control-sm" name="update-bus-number" placeholder="Enter Bus Number" required>
          </div>
        </div>
        
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Bus Type</label>
                <select class="form-select" id="bus-type-update" required>
                    <!-- Bus types will be dynamically loaded here -->
                </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Bus Seats</label>
              <input type="number" class="form-control form-control-sm" name="update-bus-seats" placeholder="Enter Bus Seats" required>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update-bus-btn">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Delete Bus Modal -->
<div class="modal fade" id="confirm-delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
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

