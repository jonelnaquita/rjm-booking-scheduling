<div class="modal fade" id="staff-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Staff</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container mt-5">
          <form class="forms-sample" id="userForm">
            <div class="form-group">
              <label for="firstname">First Name</label>
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name"
                required>
            </div>
            <div class="form-group">
              <label for="lastname">Last Name</label>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name"
                required>
            </div>
            <div class="form-group">
              <label for="role">Role</label>
              <select id="role" name="role" class="form-control select2" required>
                <!-- Options will be populated via JavaScript -->
              </select>
            </div>
            <div class="form-group">
              <label for="terminal">Terminal</label>
              <select id="terminal" name="terminal" class="form-control select2" required>
                <!-- Options will be populated via JavaScript -->
              </select>
            </div>
            <div class="form-group">
              <label for="bus_number">Bus Number</label>
              <select id="bus_number" name="bus_number" class="form-control select2">
                <!-- Options will be populated via JavaScript -->
              </select>
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
              <small id="email-error" class="text-danger">This email is already taken.</small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
                required>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-staff" disabled>Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="edit-staff-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Staff</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="editStaffTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
              role="tab" aria-controls="info" aria-selected="true">Staff Information</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#update-password-tab"
              type="button" role="tab" aria-controls="password" aria-selected="false">Update Password</button>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="editStaffTabContent">
          <!-- Staff Information Tab -->
          <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <form class="forms-sample" id="userForm-2">
              <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" id="firstname-2" name="firstname" placeholder="Enter first name"
                  required>
              </div>
              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" id="lastname-2" name="lastname" placeholder="Enter last name"
                  required>
              </div>
              <div class="form-group">
                <label for="role">Role</label>
                <select id="role-2" name="role" class="form-control select2" required>
                  <!-- Options will be populated via JavaScript -->
                </select>
              </div>
              <div class="form-group">
                <label for="terminal">Terminal</label>
                <select id="terminal-2" name="terminal" class="form-control select2" required>
                  <!-- Options will be populated via JavaScript -->
                </select>
              </div>
              <div class="form-group">
                <label for="bus_number">Bus Number</label>
                <select id="bus_number-2" name="bus_number" class="form-control select2">
                  <!-- Options will be populated via JavaScript -->
                </select>
              </div>
              <button type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary edit-staff-btn">Save</button>
            </form>
          </div>

          <!-- Update Password Tab -->
          <div class="tab-pane fade" id="update-password-tab" role="tabpanel" aria-labelledby="password-tab">
            <form id="passwordForm">
              <div class="form-group position-relative">
                <label for="new-password">New Password</label>
                <input type="password" class="form-control" id="new-password" name="new_password"
                  placeholder="Enter new password" required>
                <span class="position-absolute end-0 translate-middle-y pe-3 toggle-password"
                  data-target="#new-password" style="top: 60px;">
                  <i class="fas fa-eye-slash"></i>
                </span>
              </div>
              <div class="form-group position-relative">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm_password"
                  placeholder="Confirm new password" required>
                <span class="position-absolute end-0 translate-middle-y pe-3 toggle-password"
                  data-target="#confirm-password" style="top: 60px;">
                  <i class="fas fa-eye-slash"></i>
                </span>
              </div>
              <button type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary edit-password-btn">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!--Delete Staff Modal -->
<div class="modal fade" id="delete-staff-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="confirmBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden" class="form-control staff_id" name="staff_id">

        <div class="alert alert-confirmation">
          <i class="fa fa-exclamation-circle"></i><br>
          <div class="alert-content">
            <span class="swal-title">Do you want to delete this staff?</span><br>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-rounded btn-fw" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="confirm-btn btn btn-primary btn-rounded btn-fw"
          id="confirm-delete">Confirm</button>
      </div>
    </div>
  </div>
</div>