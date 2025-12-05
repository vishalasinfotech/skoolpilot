<!-- ========== App Menu (SRS-aligned) ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
      <a href="#" class="logo logo-dark">
        <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="" height="22"></span>
        <span class="logo-lg"><img src="assets/images/logo-dark.png" alt="" height="17"></span>
      </a>
      <a href="#" class="logo logo-light">
        <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="" height="22"></span>
        <span class="logo-lg"><img src="assets/images/logo-light.png" alt="" height="17"></span>
      </a>
      <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
        <i class="ri-record-circle-line"></i>
      </button>
    </div>

    <div id="scrollbar">
      <div class="container-fluid">
        <div id="two-column-menu"></div>

        <ul class="navbar-nav" id="navbar-nav">
          <li class="menu-title"><span data-key="t-menu">Menu</span></li>

          <!-- Dashboards -->
          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
              <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarDashboards">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link" data-key="t-analytics">Analytics</a></li>
                <li class="nav-item"><a href="#" class="nav-link" data-key="t-superadmin">Super Admin</a></li>
                <li class="nav-item"><a href="#" class="nav-link" data-key="t-schooladmin">School Admin</a></li>
                <li class="nav-item"><a href="#" class="nav-link" data-key="t-teacher">Teacher</a></li>
              </ul>
            </div>
          </li>

          <!-- Super Admin -->
          <li class="menu-title">Super Admin</li>

          <li class="nav-item" data-role="super_admin">
            <a class="nav-link menu-link" href="#sidebarSuperAdmin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSuperAdmin">
              <i class="ri-building-line"></i> <span>School Management</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarSuperAdmin">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="{{ route('super-admin.school.index') }}" class="nav-link">All Schools</a></li>
                <li class="nav-item"><a href="{{ route('super-admin.subscription-plan.index') }}" class="nav-link">Subscriptions & Plans</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Trials</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Usage</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item" data-role="super_admin">
            <a class="nav-link menu-link" href="#">
              <i class="ri-shield-user-line"></i> <span>Permission Management</span>
            </a>
          </li>

          <li class="nav-item" data-role="super_admin">
            <a class="nav-link menu-link" href="#">
              <i class="ri-bar-chart-line"></i> <span>Revenue & Reports</span>
            </a>
          </li>

          <li class="nav-item" data-role="super_admin">
            <a class="nav-link menu-link" href="#">
              <i class="ri-chat-3-line"></i> <span>Feedback</span>
            </a>
          </li>

          <!-- School Admin -->
          <li class="menu-title">School Admin</li>

          <li class="nav-item" data-role="school_admin">
            <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUsers">
              <i class="ri-group-line"></i> <span>Users & Staff</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarUsers">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="{{ route('school-admin.teacher.index') }}" class="nav-link">Teachers</a></li>
                <li class="nav-item"><a href="{{ route('school-admin.student.index') }}" class="nav-link">Students</a></li>
                <li class="nav-item"><a href="{{ route('school-admin.staff.index') }}" class="nav-link">Staff</a></li>
                <li class="nav-item"><a href="{{ route('school-admin.teacher.bulk-import') }}" class="nav-link">Bulk Upload (Excel)</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Promotions</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item" data-role="school_admin">
            <a class="nav-link menu-link" href="#sidebarAcademic" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAcademic">
              <i class="ri-book-open-line"></i> <span>Academic</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarAcademic">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Classes & Sections</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Subjects</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Attendance</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Exams & Schedules</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Results</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item" data-role="school_admin">
            <a class="nav-link menu-link" href="#sidebarEvents" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEvents">
              <i class="ri-calendar-event-line"></i> <span>Events & Calendar</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarEvents">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Events</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Holidays</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Calendar</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item" data-role="school_admin">
            <a class="nav-link menu-link" href="#sidebarFees" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarFees">
              <i class="ri-money-dollar-circle-line"></i> <span>Fees & Finance</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarFees">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Fee Structure</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Payments & Receipts</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Accounts</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item" data-role="school_admin">
            <a class="nav-link menu-link" href="#">
              <i class="ri-paint-line"></i> <span>White-label Customization</span>
            </a>
          </li>

          <li class="nav-item" data-role="school_admin">
            <a class="nav-link menu-link" href="#">
              <i class="ri-price-tag-2-line"></i> <span>Current Plan</span>
            </a>
          </li>

          <!-- Teacher -->
          <li class="menu-title">Teacher</li>

          <li class="nav-item" data-role="teacher">
            <a class="nav-link menu-link" href="#">
              <i class="ri-user-3-line"></i> <span>Profile</span>
            </a>
          </li>

          <li class="nav-item" data-role="teacher">
            <a class="nav-link menu-link" href="#sidebarClassroom" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarClassroom">
              <i class="ri-contacts-line"></i> <span>Classroom</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarClassroom">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Attendance</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Assignments</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Exams</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Apply for Leave</a></li>
              </ul>
            </div>
          </li>

          <!-- Student & Parent -->
          <li class="menu-title">Student & Parent</li>

          <li class="nav-item" data-role="student">
            <a class="nav-link menu-link" href="#">
              <i class="ri-school-line"></i> <span>My Dashboard</span>
            </a>
          </li>

          <li class="nav-item" data-role="student">
            <a class="nav-link menu-link" href="#">
              <i class="ri-wallet-3-line"></i> <span>Fees</span>
            </a>
          </li>

          <li class="nav-item" data-role="student">
            <a class="nav-link menu-link" href="#">
              <i class="ri-file-list-3-line"></i> <span>Exam Schedule & Results</span>
            </a>
          </li>

          <li class="nav-item" data-role="parent">
            <a class="nav-link menu-link" href="#">
              <i class="ri-parent-line"></i> <span>My Children</span>
            </a>
          </li>

          <li class="nav-item" data-role="parent">
            <a class="nav-link menu-link" href="#">
              <i class="ri-file-chart-line"></i> <span>Student Reports</span>
            </a>
          </li>

          <li class="nav-item" data-role="parent">
            <a class="nav-link menu-link" href="#">
              <i class="ri-feedback-line"></i> <span>Register Complaint</span>
            </a>
          </li>

          <!-- Staff -->
          <li class="menu-title">Staff</li>

          <li class="nav-item" data-role="staff">
            <a class="nav-link menu-link" href="#sidebarStaffModules" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarStaffModules">
              <i class="ri-briefcase-4-line"></i> <span>Staff Modules</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarStaffModules">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Library</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Transportation</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Accounts</a></li>
              </ul>
            </div>
          </li>

          <!-- Communication -->
          <li class="menu-title">Communication</li>

          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarNotifications" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarNotifications">
              <i class="ri-notification-3-line"></i> <span>Notifications</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarNotifications">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Create Notification</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Notification History</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Templates</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link menu-link" href="#">
              <i class="ri-file-list-3-line"></i> <span>Reports</span>
            </a>
          </li>

          <!-- Settings / Extras -->
          <li class="menu-title text-uppercase">Extras</li>

          <li class="nav-item">
            <a class="nav-link menu-link" href="#">
              <i class="ri-calendar-2-line"></i> <span>Calendar</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSettings">
              <i class="ri-settings-3-line"></i> <span>Settings</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarSettings">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="#" class="nav-link">General</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Security</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Languages</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Payment Gateway</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
  </div>
  <!-- ========== App Menu End ========== -->
