<!-- Add Bus Type Modal -->
<div class="modal fade" id="bus-type" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
<div class="modal fade" id="new-bus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
            <input type="text" class="form-control form-control-sm" name="bus-number" placeholder="Enter Bus Number"
              required>
          </div>
        </div>

        <div class="form-group">
          <label>Terminal</label>
          <select class="form-control terminal_id" name="terminal_id">
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
              <input type="number" class="form-control form-control-sm" name="bus-seats" placeholder="Enter Bus Seats"
                required>
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

<!--Fetch Destination From-->
<script>
  $(document).ready(function () {
    $('.terminal_id').select2({
      dropdownParent: $('#new-bus'),
      width: '100%' // Ensure full width
    });

    $.ajax({
      url: '../api/schedule/fetch-destination-from.php',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        var select = $('.terminal_id');

        // Add a default empty option
        select.append('<option value="" selected disabled>Select Destination From</option>');

        $.each(data, function (index, destination) {
          select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
        });
      },
      error: function () {
        console.error('Error fetching destinations');
      }
    });
  });
</script>


<script>
  $(document).ready(function () {

    $('.destination-to').select2({
      dropdownParent: $('#new-bus'),
      width: '100%' // Ensure full width
    });

    // Event listener for when destination-from dropdown value changes
    $('.terminal_id').on('change', function () {
      var from_id = $(this).val();

      // Check if from_id is valid
      if (from_id) {
        $.ajax({
          url: '../api/schedule/fetch-destination-to.php',
          type: 'POST',
          data: { from_id: from_id },
          dataType: 'json',
          success: function (data) {
            var select = $('.destination-to');
            select.empty(); // Clear existing options

            // Add a default empty option
            select.append('<option value="" selected disabled>Select Destination To</option>');

            $.each(data, function (index, destination) {
              select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
            });
            select.trigger('change'); // Update Select2
          },
          error: function () {
            console.error('Error fetching destinations');
          }
        });
      } else {
        $('.destination-to').empty().trigger('change'); // Clear the dropdown if no from_id
      }
    });
  });
</script>

<!-- Update Bus -->
<div class="modal fade" id="update-bus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
            <input type="text" class="form-control form-control-sm" name="update-bus-number"
              placeholder="Enter Bus Number" required>
          </div>
        </div>

        <div class="form-group">
          <label>Terminal</label>
          <select class="form-control update_terminal_id" name="update_terminal_id">
            <!-- Options will be dynamically added here -->
          </select>
        </div>

        <div class="form-group">
          <label>Destination To</label>
          <select class="form-control update-destination-to" name="update-destination-to">
            <!-- Options will be dynamically added here -->
          </select>
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
              <input type="number" class="form-control form-control-sm" name="update-bus-seats"
                placeholder="Enter Bus Seats" required>
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

<!--Fetch Destination From-->
<script>
  $(document).ready(function () {
    $('.update_terminal_id').select2({
      dropdownParent: $('#update-bus'),
      width: '100%' // Ensure full width
    });
  });
</script>


<script>
  $(document).ready(function () {

    $('.update-destination-to').select2({
      dropdownParent: $('#update-bus'),
      width: '100%' // Ensure full width
    });
  });
</script>

<!-- Confirm Delete Bus Modal -->
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