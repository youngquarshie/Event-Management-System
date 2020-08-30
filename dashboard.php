<?php
include 'includes/connect.php';
include 'assets/Hash.php';
include 'views/views.php';
$views = new Views();
	if($_SESSION['customer_sid']==session_id())
	{
    
		?>
<!DOCTYPE html>
<html>
<?php include ('organizer/includes/head.php');?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include ('organizer/includes/navbar.php');?>
    <!-- closing nav bar  -->

  <!-- Main Sidebar Container -->
  <?php include ('organizer/includes/sidebar.php');?>
   
  <?php if(isset($_GET['users'])){
      echo $views->users($con);
  }

  else if(isset($_GET['logout'])){
    echo $views->logout();
}

  elseif(isset($_GET['create'])){
    echo $views->create_event($con);
  }

  elseif(isset($_GET['attendees'])){
    echo $views->attendees($con);
  }


  elseif(isset($_GET['view_attendees'])){
    echo $views->view_attendees($con);
  }

  elseif(isset($_GET['chpwd'])){
    echo $views->change_password($con);
  }

  

  elseif(isset($_GET['create_ticket'])){
    echo $views->create_tickets($con);
  }

  elseif(isset($_GET['create_event_ticket'])){
    echo $views->add_tickets($con);
  }

  elseif(isset($_GET['speaker'])){
    echo $views->add_speaker($con);
  }

  elseif(isset($_GET['edit_speaker'])){
    
    echo $views->edit_speaker($con);
  }

  elseif(isset($_GET['my_events'])){
    echo $views->user_event($con);
  }

  elseif(isset($_GET['sales'])){
    echo $views->user_sales($con);
  }

  elseif(isset($_GET['my_attendees'])){
    echo $views->user_attendees($con);
  }

  elseif(isset($_GET['verify_ticket'])){
    echo $views->verify_ticket($con);
  }

  elseif(isset($_GET['view_event_details'])){
    echo $views->view_event_details($con);
  
  }

  elseif(isset($_GET['scan_event_ticket']) && isset($_GET['event_id']) && isset($_GET['user_id'])){
    
    echo $views->scan_ticket($con);
  }
  else{
  ?>
 
  <!-- Content Wrapper. Contains page content -->
  
  <?php } ?>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">KTU EventHub</a>.</strong>
    All rights reserved.
    
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include("organizer/includes/script.php");?>
<script type="text/javascript" src="js/back.js"></script>
<script>
$(document).ready(function(){

 
  $(document).on('submit', '#add_new_ticket', function(event){
		event.preventDefault();
		alert();
		$.ajax({
			url:"ajax/one.php?text=add_ticket",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				
				if(data.match('success'))
				{
					location.reload();
				}
			}
		});
	});
})


</script>



</body>
</html>

<?php
	}
	else
	{
		if($_SESSION['admin_sid']==session_id())
		{
			header("location:admin-page.php");		
		}
		else{
			header("location:login.php");
		}
	}
?>