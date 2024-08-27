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
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add New Bus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <label>Bus Number</label>
          <input type="text" class="form-control form-control-sm" name="bus-number" placeholder="Enter Bus Number" required>
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect2">Bus Type</label>
            <select class="form-select" id="bus-type-id" required>
                <!-- Bus types will be dynamically loaded here -->
            </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add-new-bus" disabled>Add</button>
      </div>
    </div>
  </div>
</div>

