<?php
include 'includes/connect.php';
include 'assets/Hash.php';
include 'views/views.php';
$views = new Views();
	if($_SESSION['admin_sid']==session_id())
	{
		?>
<!DOCTYPE html>
<html>
<?php include ('admin/includes/head.php');?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include ('admin/includes/navbar.php');?>
    <!-- closing nav bar  -->
  <!-- Main Sidebar Container -->
  <?php include ('admin/includes/sidebar.php');?>
   
  <?php if(isset($_GET['users'])){
      echo $views->users($con);
  }

  else if(isset($_GET['logout'])){
    echo $views->logout();
}

elseif(isset($_GET['chpwd'])){
  echo $views->change_password($con);
}



  elseif(isset($_GET['edit']) && isset($_GET['uid'])){
    $user=$_GET['uid'];
    echo $views->edit($con,$user);
  }

  elseif(isset($_GET['admin_dashboard'])){
    echo $views->admin_dashboard($con);

  }

  if(isset($_GET['allevents'])){
    echo $views->users($con);
}

if(isset($_GET['venue'])){
  echo $views->venues($con);
}

if(isset($_GET['add_venue'])){
  echo $views->add_venue($con);
}

if(isset($_GET['speaker_mgm'])){
    echo $views->view_speakers($con);
  
}

if(isset($_GET['event_mgm'])){
  echo $views->view_events($con);

}


if(isset($_GET['view_event_details'])){
  echo $views->view_event_details_admin($con);

}

  else{
  ?>
 
  
  <?php } ?>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">Digital Ticket</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.2
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include("admin/includes/script.php");?>

<script>
      $(document).ready(function(){
            
  
    $(document).on('submit', '#update_user', function(event){
		event.preventDefault();
		
		$.ajax({
			url:"ajax/one.php?text=update_user",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
        
        $("#message").text(data);
        $("#message").show();
			}
		});
	});
    
      });
      </script>
</body>
</html>

<?php
	}
	else
	{
		if($_SESSION['customer_sid']==session_id())
		{
			header("location:home.php");		
		}
		else{
			header("location:login.php");
		}
	}
?>