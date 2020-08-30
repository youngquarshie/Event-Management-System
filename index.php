<?php
include 'includes/connect.php';
include 'assets/Hash.php';
include 'views/home.php';
$home = new Home();
?>
<!DOCTYPE html>
  <html lang="en">
  
  <?php include("includes/head.php");?>
  
  <body>

    <?php
if(isset($_SESSION['admin_sid']) || isset($_SESSION['customer_sid']))
{
  
          require("includes/login_header.php");

          if(isset($_GET['q'])){

            echo $home->event_details($con);
          
          }

          elseif(isset($_GET['speaker_id'])){
      
            echo $home->speaker_details_org($con);
            
          }

          elseif(isset($_GET['venue_id'])){
      
            echo $home->venue_details($con);
          }

          else{
            echo $home->slider($con);

            echo $home->search_form();
      
            echo $home->main($con);
          }
}
elseif(!isset($_SESSION['admin_sid']) || !isset($_SESSION['customer_sid'])){

    // <!-- ======= Header ======= -->
     include("includes/header.php");
  

    if(isset($_GET['q'])){

      echo $home->event_details($con);
    
    }
    elseif(isset($_GET['speaker_id'])){

      echo $home->speaker_details($con);
      
    }

    elseif(isset($_GET['venue_id'])){
      
      echo $home->venue_details($con);
    }

    else{
      echo $home->slider($con);

      echo $home->search_form();

      echo $home->main($con);
    }
    
    
    ?>
  
  
  
   

<?php
          
}
else{

  header("location:index.php");
}

// <!-- ======= Footer ======= -->
include ("includes/footer.php");?>

<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>


 <?php include('includes/script.php');?>

<style>
.section-with-bg {
  background-color: white;
}

</style>
</body>

</html>
