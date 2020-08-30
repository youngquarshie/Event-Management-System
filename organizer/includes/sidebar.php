<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:white;">
    <!-- Brand Logo -->
    <!-- <a href="admin-page.php" class="brand-link">
      <img src="admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="assets/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <div class="d-block text-black"><?php echo $_SESSION['name'];?></div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            
          </li>
          <li class="nav-item">
            <a href="dashboard.php?sales=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
              <i class="nav-icon fa fa-tachometer-alt" style="color:black"></i>
              <p>
                Dashboard
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-ticket-alt" style="color:black"></i>
              <p>
                Ticket Management
                <i class="fas fa-angle-left right" style="color:black"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="dashboard.php?create_ticket=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
                  <i class="fa fa-plus nav-icon" style="color:black"></i>
                  <p>Create Ticket</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="dashboard.php?verify_ticket=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
                  <i class="fa fa-user-check nav-icon" style="color:black"></i>
                  <p>Verify Ticket</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar" style="color:black"></i>
              <p>
                Events
                <i class="fas fa-angle-left right" style="color:black"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="dashboard.php?create=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
                  <i class="fa fa-plus nav-icon" style="color:black"></i>
                  <p>Add New Event</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="dashboard.php?my_events=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
                  <i class="fa fa-calendar-week nav-icon" style="color:black"></i>
                  <p>My Events</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="dashboard.php?attendees=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
              <i class="nav-icon fas fa-users" style="color:black"></i>
              <p>
                Attendees
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="dashboard.php?speaker=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
              <i class="nav-icon fas fa-headset" style="color:black"></i>
              <p>
                Speaker/MC
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="dashboard.php?chpwd=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
              <i class="nav-icon fas fa-unlock" style="color:black"></i>
              <p>
                Change Password
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="dashboard.php?logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt" style="color:black"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        
          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <style>

    .nav-item  p{
      color:black !important;
    }
  </style>