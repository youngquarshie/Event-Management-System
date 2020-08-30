<?php
    class Home
    {

        function search_form(){
            $output='';

            $output.='
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

            <div class="container">
    <br/>
	<div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <form class="card card-sm">
                                <div class="card-body row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <i class="fas fa-search h4 text-body"></i>
                                    </div>
                                    <!--end of col-->
                                    <div class="col">
                                        <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Search topics or keywords">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-auto">
                                        <button class="btn btn-lg btn-success" type="submit">Search</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
                    </div>
</div>

<style>
.form-control-borderless {
    border: none;
}

.form-control-borderless:hover, .form-control-borderless:active, .form-control-borderless:focus {
    border: none;
    outline: none;
    box-shadow: none;
}
</style>

            ';

            return $output;
        }
       
        function slider($con){
            $hash = Hash::unique();
            $output ='';

            $select=mysqli_query($con, "SELECT * FROM all_events 
            INNER JOIN event_category ON event_category.category_id = all_events.event_type
            INNER JOIN venues ON all_events.id_venue=venues.venue_id 
            ORDER BY RAND()") or die(mysqli_error($con));
            while($row=mysqli_fetch_assoc($select)){
	  $event_name=$row['event_name'];
	  $event_id=$row['event_id'];
	  $event_description=$row['event_description'];
	  $event_image=$row['image_path'];
	  $event_date =$row['start_date'];
	  $event_time =$row['start_time']." ".$row['end_time'];
      $event_venue =$row['venue_name'];
      
      $day= date('d',strtotime($event_date));
      $month=  date('M',strtotime($event_date));
      $year= date('Y',strtotime($event_date));
     }

     $output.='
  <!-- ======= Intro Section ======= -->
  <section id="intro" style="background: url(images/event_images/'.$event_image.') top center; width: 100%;
  height: 100vh;
  background-size: cover;
  overflow: hidden;
  position: relative;" >
   
  </section><!-- End Intro Section -->
  
  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h2>About The Event</h2>
            <p>'.$event_description.'</p>
          </div>
          <div class="col-lg-3">
            <h3>Where</h3>
            <p>'.$event_venue.'</p>
          </div>
          <div class="col-lg-3">
            <h3>When</h3>
            <p>'.$day.'<span>. '.$month.'.'.$year.'</span></p>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->';


            return $output;
        }


        function main($con){
            $hash=Hash::unique();
            $output='';
            $output.='

            <section id="hotels" class="section-with-bg wow fadeInUp">

            <div class="container">
    <div class="section-header">
    <h2>Upcoming Events</h2>
    <!-- <p>Her are some nearby venues</p> -->
    </div>
  
    <div class="row">';
        
    $select=mysqli_query($con, "SELECT * FROM all_events 
    INNER JOIN event_category ON event_category.category_id = all_events.event_type
    INNER JOIN venues ON all_events.id_venue=venues.venue_id 
    WHERE event_category.category_name ='Other' ORDER BY RAND() ") or die(mysqli_error($con));
    while($row=mysqli_fetch_assoc($select)){
      $event_name=$row['event_name'];
      $event_id=$row['event_id'];
      $event_description=$row['event_description'];
      $event_image=$row['image_path'];
      $event_date =$row['start_date'];
      $event_time =$row['start_time']." ".$row['end_time'];
      $event_venue =$row['venue_name'];

      $day= date('d',strtotime($event_date));
      $month=  date('M',strtotime($event_date));
      $year= date('Y',strtotime($event_date));
      $output.='
  
      <a href="index.php?q='.$hash.'&event_id='.$event_id.'"> 
        <div class="col-lg-4 col-md-6">
            <div class="hotel">
            <div class="hotel-img">
                <img src="images/event_images/'.$event_image.'" alt="Book Launch" class="img-fluid">
        </div>
        <center>
            <h4><a href="index.php?q='.$hash.'&event_id='.$event_id.'"> '.nl2br(strip_tags(html_entity_decode($event_name))).'</a></h4>
            <h5><a style="color:rgb(236,38,143);">'.$day.'.<span>'.$month.'.'.$year.'</a></h5>
            <div class="social">
            <a class="speak" id="'.$event_id.'"><i style="font-size:25px !important;" class="fa fa-microphone"></i></a>
            <div id="play_audio"></div>
            </div>
        </center>
        
        </div>
        </div>
    </a>';
    
    }

    $output.='
  
    </div>
  </div>
  
  </section><!-- End other events Section -->
  
    <section id="musicevent" class="section-with-bg wow fadeInUp">
  
  <div class="container">
  
    <div class="section-header">
    <h2>Upcoming Musical Concerts</h2>
    <!-- <p>Here are some nearby venues</p> -->
    </div>
  
    <div class="row">';
    $select=mysqli_query($con, "SELECT * FROM all_events 
    INNER JOIN event_category ON event_category.category_id = all_events.event_type
    INNER JOIN venues ON all_events.id_venue=venues.venue_id 
    WHERE event_category.category_name ='Music' ORDER BY RAND()") or die(mysqli_error($con));
    while($row=mysqli_fetch_assoc($select)){
      $event_name=$row['event_name'];
      $event_id=$row['event_id'];
      $event_description=$row['event_description'];
      $event_image=$row['image_path'];
      $event_date =$row['start_date'];
      $event_time =$row['start_time']."".$row['end_time'];
      $event_venue =$row['venue_name'];
      $day= date('d',strtotime($event_date));
      $month=  date('M',strtotime($event_date));
      $year= date('Y',strtotime($event_date));
    
        $output.='
        <a href="index.php?q='.$hash.'&event_id='.$event_id.'">   
      <div class="col-lg-4 col-md-6">
        <div class="hotel">
          <div class="hotel-img">
            <img src="images/event_images/'.$event_image.'" alt="Hotel 1" class="img-fluid">
      </div>
      <center>
      <h4><a href="index.php?q='.$hash.'&event_id='.$event_id.'"> '.nl2br(strip_tags(html_entity_decode($event_name))).'</a></h4>
      <h5><a style="color:rgb(236,38,143);">'.$day.'.<span>'.$month.'.'.$year.'</a></h5>
      <div class="social">
      <a class="speak" id="'.$event_id.'"><i style="font-size:25px !important;" class="fa fa-microphone"></i></a>
      <div id="play_audio"></div>
      </div>      
      </center>
       
      </div>
    </div>
    </a>';
    
    }
    
    $output.='
    
  
    </div>
  </div>
  
  </section><!-- End upcoming Musical Section -->
  
  <section id="seminar" class="section-with-bg wow fadeInUp">
  
  <div class="container">
    <div class="section-header">
    <h2>Upcoming Seminars</h2>
    <!-- <p>Her are some nearby venues</p> -->
    </div>
  
    <div class="row">';
          
    $select=mysqli_query($con, "SELECT * FROM all_events 
    INNER JOIN event_category ON event_category.category_id = all_events.event_type
    INNER JOIN venues ON all_events.id_venue=venues.venue_id 
    WHERE event_category.category_name ='Seminar' ORDER BY RAND() ") or die(mysqli_error($con));
    while($row=mysqli_fetch_assoc($select)){
      $event_name=$row['event_name'];
      $event_id=$row['event_id'];
      $event_description=$row['event_description'];
      $event_image=$row['image_path'];
      $event_date =$row['start_date'];
      $event_time =$row['start_time']."".$row['end_time'];
      $event_venue =$row['venue_name'];
      $day= date('d',strtotime($event_date));
      $month=  date('M',strtotime($event_date));
      $year= date('Y',strtotime($event_date));
      
      $output.='
      
      <a href="index.php?q='.$hash.'&event_id='.$event_id.'">  
      <div class="col-lg-4 col-md-6">
        <div class="hotel">
          <div class="hotel-img">
            <img src="images/event_images/'.$event_image.'" alt="Hotel 1" class="img-fluid">
      </div>
      <center>
      <h4><a href="index.php?q='.$hash.'&event_id='.$event_id.'"> '.nl2br(strip_tags(html_entity_decode($event_name))).'</a></h4>
      <h5><a style="color:rgb(236,38,143);">'.$day.'.<span>'.$month.'.'.$year.'</a></h5>
      <div class="social">
      <a class="speak" id="'.$event_id.'"><i style="font-size:25px !important;" class="fa fa-microphone"></i></a>
      <div id="play_audio"></div>
      </div>
      
      </center>
       
      </div>
    </div>
    </a>';
    
    }
    
    $output.='
  
    </div>
  </div>
  
  </section><!-- End seminar Section -->
  
  
  <section id="booklaunch" class="section-with-bg wow fadeInUp">
  
  <div class="container">
    <div class="section-header">
    <h2>Upcoming Book Launching Events</h2>
    <!-- <p>Her are some nearby venues</p> -->
    </div>
  
    <div class="row">';
    
    $select=mysqli_query($con, "SELECT * FROM all_events 
    INNER JOIN event_category ON event_category.category_id = all_events.event_type 
    INNER JOIN venues ON all_events.id_venue=venues.venue_id
    WHERE event_category.category_name ='Book Launch' ORDER BY RAND()") or die(mysqli_error($con));
    while($row=mysqli_fetch_assoc($select)){
      $event_name=$row['event_name'];
      $event_id=$row['event_id'];
      $event_description=$row['event_description'];
      $event_image=$row['image_path'];
      $event_date =$row['start_date'];
      $event_time =$row['start_time']." ".$row['end_time'];
      $event_venue =$row['venue_name'];
      $day= date('d',strtotime($event_date));
      $month=  date('M',strtotime($event_date));
      $year= date('Y',strtotime($event_date));
      
      $output.='
  
      <a href="index.php?q='.$hash.'&event_id='.$event_id.'">   
    <div class="col-lg-4 col-md-6">
        <div class="hotel">
          <div class="hotel-img">
            <img src="images/event_images/'.$event_image.'" alt="Book Launch" class="img-fluid">
      </div>
      <center>
      <h4><a href="index.php?q='.$hash.'&event_id='.$event_id.'"> '.nl2br(strip_tags(html_entity_decode($event_name))).'</a></h4>
      <h5><a style="color:rgb(236,38,143);">'.$day.'.<span>'.$month.'.'.$year.'</a></h5>
      <div class="social">
      <a class="speak" id="'.$event_id.'"><i style="font-size:25px !important;" class="fa fa-microphone"></i></a>
      <div id="play_audio"></div>
      </div>
      
      </center>
       
      </div>
    </div>
    </a>';
    
    }
    
    $output.='
  
    </div>
  </div>
  
  </section><!-- End booklaunch Section -->
  
      <!-- ======= Speakers Section ======= -->
      <section id="speakers" class="wow fadeInUp">
        <div class="container">
          <div class="section-header">
            <h2>ARE YOU LOOKING FOR RENOWNED SPEAKERS FOR YOUR EVENT?</h2>
            <p>Here are some of the speakers</p>
          </div>
  
          <div class="row">';

              $select=mysqli_query($con, "SELECT status, speaker_id, speaker_type, full_name, image_path FROM speakers ORDER BY RAND()") 
              or die(mysqli_error($con));
              while($row=mysqli_fetch_assoc($select)){
                $speaker_id=$row['speaker_id'];
                $speaker_type=$row['speaker_type'];
  
            $speaker_name=$row['full_name'];
              $speaker_image=$row['image_path'];
              $status=$row['status'];
              
              $output.='
              
              <div class="col-lg-4 col-md-6">
              <div class="speaker">
                <img src="images/speaker_images/'.$speaker_image.'" alt="Speaker 1" class="img-fluid">
                <div class="details">
                  <h4><a href="index.php?speaker_id='.$speaker_id.'">'.$speaker_name.'</a></h4>';
                  if($speaker_type==1){
                    $output.='
                    <p>General Speaker</p>';
                    
                  }
                  $output.='
                  
                </div>
              </div>
            </div>';
    
             }
             $output.='
  
          </div>
        </div>
  
      </section><!-- End Speakers Section -->
  
  
      <!-- ======= Hotels Section ======= -->
      <section id="venue" class="section-with-bg wow fadeInUp">
  
        <div class="container">
          <div class="section-header">
            <h2>Are you looking for Venues to Host your Event</h2>
            <p>Here are some nearby venues</p>
          </div>
  
          <div class="row">';
  
              $select=mysqli_query($con, "SELECT * FROM venues ORDER BY RAND()") 
              or die(mysqli_error($con));
              while($row=mysqli_fetch_assoc($select)){
                $venue_id=$row['venue_id'];
                $venue_name=$row['venue_name'];
  
                $venue_location=$row['venue_location'];
              $venue_image=$row['path_image'];
              $location= substr(strip_tags(html_entity_decode($venue_location)), 0, 500);
              

              $output.='
  
            <div class="col-lg-4 col-md-6">
              <div class="hotel">
                <div class="hotel-img">
                  <img src="images/venue_images/'.$venue_image.'" alt="Hotel 1" class="img-fluid">
                </div>
                <h3><a href="index.php?venue_id='.$venue_id.'&vid='.$hash.'">'.$venue_name.'</a></h3>
                <div class="stars">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                </div>
                <p>'.$location.'</p>
              </div>
            </div>';
    
             }

             $output.='
  
          </div>
        </div>
  
      </section><!-- End venue Section -->
  
      <!-- ======= Gallery Section ======= -->
      <section id="gallery" class="wow fadeInUp">
  
        <div class="container">
          <div class="section-header">
            <h2>Gallery</h2>
            <p>Check out the gallery of upcoming events</p>
          </div>
        </div>
  
        <div class="owl-carousel gallery-carousel">';
    $select=mysqli_query($con, "SELECT * FROM all_events 
    INNER JOIN event_category ON event_category.category_id = all_events.event_type ORDER BY RAND() ") or die(mysqli_error($con));
    while($row=mysqli_fetch_assoc($select)){
  
      $event_image=$row['image_path'];
      $output.='
          <a href="images/event_images/'.$event_image.'" class="venobox" data-gall="gallery-carousel"><img src="images/event_images/'.$event_image.'" alt=""></a>';
          
     }

    $output.='
        </div>
  
      </section>
  
  
    </main>';

    return $output;

    
        }

        //user not logged in event details
        function event_details($con){
            $hash=Hash::unique();

            $output='';            
              
              if(isset($_GET['event_id']) && isset($_GET['q'])){
                $event_id=$_GET['event_id'];
                $select=mysqli_query($con, "SELECT * FROM all_events INNER JOIN 
                event_category ON event_category.category_id = all_events.event_type 
                INNER JOIN venues ON all_events.id_venue=venues.venue_id 
                WHERE all_events.event_id='$event_id' ") or die(mysqli_error($con));
                        while($row=mysqli_fetch_assoc($select)){
                $event_name=$row['event_name'];
                  
                  $event_id=$row['event_id'];
                  $event_description=$row['event_description'];
                  $event_image=$row['image_path'];
                  $event_date =$row['start_date'];
                  $event_time =$row['start_time']." ".$row['end_time'];
                  $event_venue =$row['venue_name'];
                  $day= date('d',strtotime($event_date));
                  $month=  date('M',strtotime($event_date));
                  $year= date('Y',strtotime($event_date));
                 }
                 
                 $output.='
            
            
              <!-- ======= Intro Section ======= -->
              <section id="intro" style="background: url(images/event_images/'.$event_image.') top center; width: 100%;
              height: 100vh;
              background-size: cover;
              overflow: hidden;
              position: relative;">
        
              
              </section><!-- End Intro Section -->
              
            
              <main id="main">
            
                <!-- ======= About Section ======= -->
                <section id="about">
                  <div class="container">
                    <div class="row">
                      <div class="col-lg-6">
                        <h2>About The Event</h2>
                        <p>'.nl2br(strip_tags(html_entity_decode($event_description))).'</p>
                      </div>
                      <div class="col-lg-3">
                        <h3>Where</h3>
                        <p>'.$event_venue.'</p>
                      </div>
                      <div class="col-lg-3">
                        <h3>When</h3>
                        <p>'.$day.'.<span>'.$month.'.'.$year.'</p>
                      </div>
                    </div>
                  </div>
                </section><!-- End About Section -->
                
            
            <br>
                <br>
            <center>
            <img id="event_image" src="images/event_images/'.$event_image.'"
            </center>';
            
        
                    $event_id=$_GET['event_id'];
                    
                    $select=mysqli_query($con, "SELECT * FROM all_events
                    WHERE event_id='$event_id'") or die(mysqli_error($con));
                    $row=mysqli_fetch_assoc($select);
                    $ticket_type=$row['ticket_type'];
                    
                    
                    if($ticket_type==3){
                      
                      $output.='
            
                  <section id="buy-tickets" class="section-with-bg wow fadeInUp">
                  <div class="container">
            
                    <div class="section-header">
                      <h2>TICKET</h2>
                    </div>
            
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card mb-5 mb-lg-0">
                          <div class="card-body">
                            <h5 class="card-title text-muted text-uppercase text-center">FREE TICKET WITHOUT REGISTERATION</h5>
                            <h6 class="card-price text-center">Gh¢ 0.0</h6>
                            <hr>
                            <!-- <div class="text-center">
                              <button type="button" class="btn" data-toggle="modal" data-target="#buy-ticket-modal" data-ticket-type="standard-access">Register</button>
                            </div> -->
                          </div>
                        </div>
                      </div>
                
                    </div>
            
                  </div>
            
                
                </section><!-- End Buy Ticket Section -->';
            
            
                    }
            
                    elseif($ticket_type==1){
                      $output.='
                      <section id="buy-tickets" class="section-with-bg wow fadeInUp">
                  <div class="container">
            
                    <div class="section-header">
                      <h2>Buy Tickets</h2>
                    </div>
            
                    <div class="row">';
            
                    $event_id=$_GET['event_id'];
                    $select=mysqli_query($con, "SELECT * FROM event_tickets
                    WHERE event_id='$event_id'") or die(mysqli_error($con));
                    while($row=mysqli_fetch_assoc($select)){
                    $ticket_id=$row['ticket_id'];
                      
                    $ticket_name=$row['ticket_name'];
                    $ticket_price=$row['ticket_price'];
                     
                    $output.='
                      <div class="col-lg-6">
                        <div class="card mb-5 mb-lg-0">
                          <div class="card-body">
                            <h5 class="card-title text-muted text-uppercase text-center">'.$ticket_name.'</h5>
                            <h6 class="card-price text-center">Gh¢'.$ticket_price.'</h6>
                            <hr>
                            <div class="text-center">
                              <button type="submit" class="btn buy_ticket" id="'.$ticket_id.'">Buy Now</button>
                            </div>
                          </div>
                        </div>
                      </div>';
                      
                     }
            
                   $output.='
                    </div>
            
                  </div>
            
                  <!-- Modal Order Form -->
                  <div id="buy-ticket-modal" class="modal fade">
                    <div class="modal-dialog" role="document" >
                    <div class="modal-content" id="display_data">
            
                    </div>  
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
            
                </section><!-- End Buy Ticket Section -->';
                      
                    }
                    else{
                      $output.='
                      <section id="buy-tickets" class="section-with-bg wow fadeInUp">
                  <div class="container">
            
                    <div class="section-header">
                      <h2>Buy Tickets</h2>
                    </div>
            
                    <div class="row">';
       
                    $event_id=$_GET['event_id'];
                    $output.='
                      <div class="col-lg-12">
                        <div class="card mb-5 mb-lg-0">
                          <div class="card-body">
                            <h5 class="card-title text-muted text-uppercase text-center">Register Free</h5>
                            <h6 class="card-price text-center">Gh¢ 0.0</h6>
                            <hr>
                            <div class="text-center">
                              <button type="submit" id="'.$event_id.'" class="btn register_ticket" >Register</button>
                            </div>
                          </div>
                        </div>
                      </div>
                
                    </div>
            
                  </div>
            
                  <!-- Modal Order Form -->
                  <div id="register-ticket-modal" class="modal fade">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
            
                </section><!-- End Buy Ticket Section -->';
                      
                    }
                     
                    $output.='
            
            
                <section id="hotels" class="section-with-bg wow fadeInUp">
            
            <div class="container">
              <div class="section-header">
                <h2>Other Events</h2>
                <!-- <p>Here are some other events</p> -->
              </div>
            
              <div class="row">';
              
              $select=mysqli_query($con, "SELECT * FROM all_events INNER JOIN 
              event_category ON event_category.category_id = all_events.event_type
              INNER JOIN venues ON all_events.id_venue=venues.venue_id 
              WHERE event_category.category_name !='Sports' ORDER BY RAND() ") or die(mysqli_error($con));
              while($row=mysqli_fetch_assoc($select)){
                  $event_name=$row['event_name'];
                  $event_id=$row['event_id'];
                  $event_description=$row['event_description'];
                  $event_image=$row['image_path'];
                  $event_date =$row['start_date'];
                  $event_time =$row['start_time']." ".$row['end_time'];
                  $event_venue =$row['venue_name'];
                
                  $output.='
        
                <a href="index.php?q='.$hash.'&event_id='.$event_id.'">   
                <div class="col-lg-4 col-md-6">
                      <div class="hotel">
                            <div class="hotel-img">
                              <img src="images/event_images/'.$event_image.'" class="img-fluid">
                    </div>
                    <center>
                        <h4><a href="index.php?q='.$hash.'&event_id='.$event_id.'">'.nl2br(strip_tags(html_entity_decode($event_name))).'</a></h4>
                        <h5><a style="color:rgb(236,38,143);">'.$day.'.<span>'.$month.'.'.$year.'</a></h3>
                        <div class="social">
                            <a class="speak" id="'.$event_id.'"><i style="font-size:25px !important;" class="fa fa-microphone"></i></a>
                            <div id="play_audio"></div>
                        </div>
                    </center>
                   
                  </div>
                </div>
              </a>';
                

              }
              
              $output.='
            
              </div>
            </div>
            
            </section><!-- End booklaunch Section -->';
            
        
              }
              $output.='
        
            
            <!-- End seminar Section -->
              </main><!-- End #main -->


            ';

            return $output;

        }


        function speaker_details($con){
            $output='';

            $output.='
            <main id="main" class="main-page">

    <!-- ======= Speaker Details Sectionn ======= -->
    <section id="speakers-details" class="wow fadeIn">
      <div class="container">
        <div class="section-header">
          <h2>Speaker Details</h2>
        </div>

        <?php ?>

        <div class="row">';
            
            if(isset($_GET['speaker_id'])){
                $speaker_id=$_GET['speaker_id'];

                $select=mysqli_query($con, "SELECT * FROM speakers 
                WHERE speaker_id='$speaker_id' ORDER BY RAND()") 
                or die(mysqli_error($con));
                $row=mysqli_fetch_assoc($select);
                  $speaker_id=$row['speaker_id'];
                  $speaker_type=$row['speaker_type'];
                  $speaker_name=$row['full_name'];
                  $speaker_image=$row['image_path'];
                  $speaker_profile=$row['speaker_profile'];

              
                $output.='
                 <div class="col-md-4">
                    <img src="images/speaker_images/'.$speaker_image.'" alt="Speaker 1" class="img-fluid">
                </div>

                <div class="col-md-8">
                    <div class="details">
                        <h2><'.$speaker_name.'</h2>
                            <div class="social">
                                <a href=""><i class="fa fa-twitter"></i></a>
                                <a href=""><i class="fa fa-facebook"></i></a>
                                <a href=""><i class="fa fa-google-plus"></i></a>
                                <a href=""><i class="fa fa-linkedin"></i></a>
                            </div>
                                <p>'.nl2br(strip_tags(html_entity_decode($speaker_profile))).'</p>

                    </div>
                </div>';

    
            
            }
            
    $output.='

            </div>
      </div>

    </section>

  </main><!-- End #main -->
            ';

            return $output;
        }
        
        

        function speaker_details_org($con){
            $output='';

            $output.='
            <main id="main" class="main-page">

    <!-- ======= Speaker Details Sectionn ======= -->
    <section id="speakers-details" class="wow fadeIn">
      <div class="container">
        <div class="section-header">
          <h2>Speaker Details</h2>
        </div>

        <?php ?>

        <div class="row">';
            
            if(isset($_GET['speaker_id'])){
                $speaker_id=$_GET['speaker_id'];

                $select=mysqli_query($con, "SELECT * FROM speakers 
                WHERE speaker_id='$speaker_id' ORDER BY RAND()") 
                or die(mysqli_error($con));
                $row=mysqli_fetch_assoc($select);
                  $speaker_id=$row['speaker_id'];
                  $speaker_type=$row['speaker_type'];
                  $speaker_name=$row['full_name'];
                  $speaker_image=$row['image_path'];
                  $speaker_profile=$row['speaker_profile'];

              
                $output.='
                 <div class="col-md-4">
                    <img src="images/speaker_images/'.$speaker_image.'" alt="Speaker 1" class="img-fluid">
                </div>

                <div class="col-md-8">
                    <div class="details">
                        <h2>'.$speaker_name.'</h2>
                            <div class="social">
                                <a href=""><i class="fa fa-twitter"></i></a>
                                <a href=""><i class="fa fa-facebook"></i></a>
                                <a href=""><i class="fa fa-google-plus"></i></a>
                                <a href=""><i class="fa fa-linkedin"></i></a>
                            </div>
                                <p>'.nl2br(strip_tags(html_entity_decode($speaker_profile))).'</p>
                                <button type="submit" class="btn btn-primary" id="'.$speaker_id.'">Send Message</button>

                    </div>
                </div>';

    
            
            }
            
    $output.='

            </div>
      </div>

    </section>

  </main><!-- End #main -->
            ';

            return $output;
        }
        
        
        function venue_details($con){
            $output='';

            $output.='
            <main id="main" class="main-page">

    <!-- ======= Speaker Details Sectionn ======= -->
    <section id="speakers-details" class="wow fadeIn">
      <div class="container">
        <div class="section-header">
          <h2>Speaker Details</h2>
        </div>

        <?php ?>

        <div class="row">';
            
            if(isset($_GET['venue_id'])){
                echo $venue_id=$_GET['venue_id'];

                $select=mysqli_query($con, "SELECT * FROM venues 
                WHERE venue_id='$venue_id' ORDER BY RAND()") 
                or die(mysqli_error($con));
                $row=mysqli_fetch_assoc($select);
                  $venue_id=$row['venue_id'];
                  $venue_name=$row['venue_name'];
                  $venue_location=$row['venue_location'];
                  $venue_image=$row['path_image'];

                $output.='
                 <div class="col-md-4">
                    <img src="images/venue_images/'.$venue_image.'" alt="Speaker 1" class="img-fluid">
                </div>

                <div class="col-md-8">
                    <div class="details">
                        <h2><'.$venue_name.'></h2>
                            <div class="social">
                                <a href=""><i class="fa fa-twitter"></i></a>
                                <a href=""><i class="fa fa-facebook"></i></a>
                                <a href=""><i class="fa fa-google-plus"></i></a>
                                <a href=""><i class="fa fa-linkedin"></i></a>
                            </div>
                                <p>'.nl2br(strip_tags(html_entity_decode($venue_location))).'</p>

                    </div>
                </div>';

    
            
            }
            
    $output.='

            </div>
      </div>

    </section>

  </main><!-- End #main -->
            ';

            return $output;
        }
    }

