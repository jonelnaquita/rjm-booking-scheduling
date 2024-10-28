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
          <li class="nav-item"> <a class="nav-link" href="booking.php">View Bookings</a></li>
          <li class="nav-item"> <a class="nav-link" href="booking-confirmed.php">Confirmed</a></li>
          <li class="nav-item"> <a class="nav-link" href="booking-reschedule-list.php">Re-schedule</a></li>
          <li class="nav-item"> <a class="nav-link" href="booking-cancellation.php">Cancellations</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#schedules" aria-expanded="false" aria-controls="schedules">
        <i class="icon-clock menu-icon"></i>
        <span class="menu-title">Schedules</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="schedules">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="schedule.php">View Schedules</a></li>
          <li class="nav-item"> <a class="nav-link" href="schedule-archives.php">Archives</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="reports.php" aria-expanded="false" aria-controls="reports">
        <i class="icon-folder menu-icon"></i>
        <span class="menu-title">Reports</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="settings.php" aria-expanded="false" aria-controls="auth">
        <i class="icon-server menu-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>
  </ul>
</nav>