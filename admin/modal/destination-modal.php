

<!-- Modal -->
<div class="modal fade" id="destination-modal" tabindex="-1" aria-labelledby="destination-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Drop-off Location</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Hidden input to hold pickup_id -->
        <input type="hidden" id="pickup-location" name="pickup_id" class="form-control form-control-sm">
    
        <div class="form-group">
            <label>Drop-off Location</label>
            <select class="form-control destination-to" name="drop_off[]" multiple="multiple">
                 <!-- Options will be dynamically added here -->
            </select> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
      </div>
    </div>
  </div>
</div>


<!--Destination Modal -->
<div class="modal fade" id="add-destination" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Destination</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Destination</label>
          <input type="text" class="form-control form-control-sm" name="destination" id="destination-input" placeholder="Destination" aria-label="destination" required>
        </div>
        <div class="form-group">
          <label>Province</label>
          <select class="form-select province form-select-sm" name="provinces[]" id="province-input" required>
            <!-- Options will be dynamically added here -->
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-destination">Save</button>
      </div>
    </div>
  </div>
</div>




<!--Province Modal -->
<div class="modal fade" id="add-province" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Province</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Province</label>
          <input type="text" class="form-control form-control-sm" name="province" placeholder="Province Name" aria-label="province" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary save-province">Save</button>
      </div>
    </div>
  </div>
</div>


<!--Delete Drop Off Destination-->

<div class="modal fade" id="deleteDestination" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Do you want to continue?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
                <input id="edit-id" type="hidden" readonly></input>
                <input id="from-id" type="hidden" readonly></input>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>



