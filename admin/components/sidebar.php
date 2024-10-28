<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="home.php">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#bookings" aria-expanded="false" aria-controls="bookings">
        <i class="icon-archive menu-icon"></i>
        <span class="menu-title">Bookings</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="bookings">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="booking.php" id="view-bookings">View Bookings</a></li>
          <li class="nav-item"> <a class="nav-link" href="booking-confirmed.php" id="confirmed-bookings">Confirmed</a></li>
          <li class="nav-item"> <a class="nav-link" href="booking-reschedule-list.php" id="reschedule-bookings">Re-schedule</a></li>
          <li class="nav-item"> <a class="nav-link" href="booking-cancellation.php" id="cancellation-bookings">Cancelled</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="destination.php" aria-expanded="false" aria-controls="form-elements">
        <i class="icon-location menu-icon"></i>
        <span class="menu-title">Destinations</span>
      </a>  
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#schedules" aria-expanded="false" aria-controls="schedules">
        <i class="icon-clock menu-icon"></i>
        <span class="menu-title">Schedules</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="schedules">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="schedule.php" id="view-schedules">View Schedules</a></li>
          <li class="nav-item"> <a class="nav-link" href="schedule-archives.php" id="schedule-archives">Archives</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="bus-management.php" aria-expanded="false" aria-controls="charts">
        <i class="icon-grid-2 menu-icon"></i>
        <span class="menu-title">Bus Management</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="staff-management.php" aria-expanded="false" aria-controls="tables">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Manage Staffs</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="reports.php" aria-expanded="false" aria-controls="reports">
        <i class="icon-folder menu-icon"></i>
        <span class="menu-title">Reports</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="reports">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Booking</a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Revenue</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="settings.php" aria-expanded="false" aria-controls="auth">
        <i class="icon-server menu-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>
  </ul>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Get the current page URL
  var currentPage = window.location.pathname.split('/').pop();

  // Remove 'active' class from all nav links
  document.querySelectorAll('.nav-link').forEach(function(el) {
    el.classList.remove('active');
  });

  // Add 'active' class to the correct nav link based on the current page
  switch(currentPage) {
    case 'schedule.php':
      document.getElementById('view-schedules').classList.add('active');
      break;
    case 'schedule-archives.php':
      document.getElementById('schedule-archives').classList.add('active');
      break;
    case 'booking.php':
      document.getElementById('view-bookings').classList.add('active');
      break;
    case 'booking-confirmed.php':
      document.getElementById('confirmed-bookings').classList.add('active');
      break;
    case 'booking-reschedule.php':
      document.getElementById('reschedule-bookings').classList.add('active');
      break;
    case 'booking-cancellation.php':
      document.getElementById('cancellation-bookings').classList.add('active');
      break;
    // Add more cases for other pages as needed
  }

  // Expand the parent collapse if a child is active
  document.querySelectorAll('.nav-link.active').forEach(function(activeLink) {
    var collapseParent = activeLink.closest('.collapse');
    if (collapseParent) {
      collapseParent.classList.add('show');
      var parentToggle = document.querySelector('[data-bs-target="#' + collapseParent.id + '"]');
      if (parentToggle) {
        parentToggle.setAttribute('aria-expanded', 'true');
      }
    }
  });
});
</script>