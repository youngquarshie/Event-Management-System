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
          <a href="#" class="d-block" style="color:black" ><?php echo $_SESSION['fname']." "; ?><?php echo $_SESSION['lname']?></a>
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
          <a href="admin-page.php?event_mgm=<?php echo Hash::unique();?>" class="nav-link">
              <i class="nav-icon fas fa-calendar" style="color:black"></i>
              <p>
                Event Management
              </p>
            </a>
          </li>



          <li class="nav-item">
          <a href="admin-page.php?speaker_mgm=<?php echo Hash::unique();?>" class="nav-link">
              <i class="nav-icon fas fa-headset" style="color:black"></i>
              <p>
                Speakers Management
              </p>
            </a>
          </li>
 

          <li class="nav-item">
            <a href="admin-page.php?users=<?php echo Hash::unique();?>" class="nav-link">
              <i class="nav-icon fas fa-user" style="color:black"></i>
              <p>
                Users
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="admin-page.php?venue=<?php echo Hash::unique();?>" class="nav-link">
              <i class="nav-icon fas fa-map" style="color:black"></i>
              <p>
                Venue Management
              </p>
            </a>
          </li>

          <li class="nav-item">
          <a href="admin-page.php?chpwd=<?php echo Hash::unique();?>&user_id=<?php echo $_SESSION['user_id'];?>" class="nav-link">
              <i class="nav-icon fas fa-unlock" style="color:black"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="admin-page.php?logout" class="nav-link">
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