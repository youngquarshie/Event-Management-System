<?php
    class Views
    {
        function logout()
        {
          $output="";
          session_start();
          session_destroy();
          
          $output = "<script>location.href = 'index.php';</script>";
          return $output;
        }

        
        
        function create_event($con){

            $hash = Hash::unique();
            $user_id=$_SESSION['user_id'];
            $output ='';
            $output .='
            <br>
            <div class="content-wrapper" style="background:white;">
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
    

        <div class="col-md-3 col-sm-6 col-xl-12">
    
              <form role="form" method="POST" id="create-event" enctype="multipart/form-data">

              <div class="form-group">
                      <input type="hidden" name="user_id" class="form-control" value="'.$user_id.'">
              </div>

                        <div class="form-group">
                                <label>Event Type</label>
                                <select name="event_type" class="form-control">
                                    <option disabled selected >Choose Event Type</option>;';
                                    $query=mysqli_query($con, "SELECT * FROM event_category") or die(mysqli_error($con));
                                    while($row=mysqli_fetch_assoc($query)){
                                        $category_id= $row['category_id'];
                                        $category_name= $row['category_name'];
                                        $output .='
                                            <option value='.$category_id.'>'.$category_name.'</option>;
                                        ';
                                    }
                                    $output .='
                                </select>
                        </div>
                    
                    <div class="form-group">
                      <label for="event_name">Event Name</label>
                      <input type="text" name="event_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                      <label for="event_desc">Description</label>
                      <textarea id="editor" name="event_description" class="form-control" rows="3" ></textarea>
                    </div>

                    <div class="form-group">
                      <label for="event_name">No of Attendees</label>
                      <input type="number" min="1" name="attendee_no" class="form-control" required>
                    </div>

                    <div class="form-group">
                                <label>Venue</label>
                                <select name="venue_id" id="venue" class="form-control" required>
                                    <option disabled selected >Choose Venue</option>;';
                                    $query=mysqli_query($con, "SELECT * FROM venues") or die(mysqli_error($con));
                                    while($row=mysqli_fetch_assoc($query)){
                                        $category_id= $row['venue_id'];
                                        $category_name= $row['venue_name'];
                                        $output .='
                                            <option value='.$category_id.'>'.$category_name.'</option>;
                                        ';
                                    }
                                    $output .='
                                </select>
                    </div>


                    <div class="row">
                           <div class="col">
                           <label for="event_date">Start Date</label>
                           <input type="text" name="start_date" id="start_date" class="form-control">
                           </div>

                           <div class="col">
                           <label for="end_date">End Date</label>
                           <input type="text" name="end_date" id="end_date" class="form-control">
                           </div>
                          
                   </div><br>

                   <div class="row">
                           <div class="col">
                           <label for="event_name">Start Time</label>
                           <input type="text" name="start_time" id="start_time" class="form-control" required>
                           </div>
                           <div class="col">
                           <label for="event_name">Closing Time</label>
                           <input type="text" name="end_time" id="end_time" class="form-control" required>
                           </div>
                   </div><br>

                   <div class="form-group">
				  	          <label for="upload_image">Cover Image </label>
						          <hr>
						            <div class="cover-image">
							            <input type="file" name="file" class="form-control-file btn-primary btn-lg btn-block" accept="image/gif, image/jpeg, image/png"  required>
						            </div>
					        </div>
                  
		
              <br>
                    <center>
                   <button type="submit" class="btn btn-primary">Create Event</button>
                   </center
                   
                   <br>
        

              </form>

            </div>
            
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
   
    </section>
    <!-- /.content -->
  </div>
  <br>
            ';
            return $output;
        }

 
        function create_tickets($con)
        {
            $output = '';
            $output .= '
            
            <div class="content-wrapper" style="background:white;">
            <br>
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- ./col -->
          <div class="col-lg-12 col-12">
          <div class="col-md-12 ">
            <!-- general form elements -->
            <div class="card card-primary">
              
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" >
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Events</h3>
              </div>
              <!-- /.card-header -->

              <!-- /loading music events for a user -->
              <div class="card-body">
                <table class="table table-bordered table-striped" id="mytable">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  ';
                  $user_id=$_SESSION['user_id'];
                  $sql=mysqli_query($con, "SELECT * FROM all_events 
                  INNER JOIN event_category ON event_category.category_id = all_events.event_type
                  INNER JOIN venues ON all_events.id_venue=venues.venue_id  
                  WHERE all_events.user_id=$user_id") or die(mysqli_error($con));
  
                  $i=1;
                  while($row=mysqli_fetch_assoc($sql)){
                      $event_id=$row['event_id'];
                      $event_name=$row['event_name'];
                      $event_desc=$row['event_description'];
                      $event_venue=$row['venue_name'];
                      $start_date=$row['event_date'];
                      $status=$row['status'];
                      $hash=Hash::unique();
                                      
                  $output .='
                  <tr>
                  <td>'.$i.'</td>  
                    <td>'.$event_name.'</td>
                    <td><a href="dashboard.php?create_event_ticket='.$hash.'&user_id='.$user_id.'&event_id='.$event_id.'" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add</a>
                  </tr>
                  ';
                  $i=$i+1;
                }
                
                $output .='
                  </tbody>
                
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
                <!-- /.card-body -->
              </form>
            </div>
            
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- ./col -->
         
          
        </div>
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
        
            ';
            
            return $output;
        }

        function add_tickets($con)
        {
            $event_id=$_GET['event_id'];
            $user_id=$_GET['user_id'];

            $hash=Hash::unique();

            $output = '';
            $output .= '
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background:white;">
              <!-- Content Header (Page header) -->
              
              <!-- Main content -->
              <section class="content">
                <div class="row">
                
                <div class="col-12">
                <br>
                <a href="dashboard.php?create_ticket='.$hash.'&user_id='.$user_id.'&event_id='.$event_id.'" class="btn btn-sm btn-danger float-right">Back</a>
                </div>
                  <div class="col-12">
                  
                  <form role="form" id="add_new_ticket" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ticket Name</label>
                      <input type="hidden"  name="user_id" value="'.$user_id.'">
                      <input type="hidden"  name="event_id" value="'.$event_id.'">
                      <input type="text" class="form-control" name="ticket_name" placeholder="Enter Ticket Name" required>
                    </div>
                    <div class="form-group">
                      <label for="end_time">Ticket Price</label>
                      <input type="text" class="form-control" name="ticket_price" required>
                    </div>
                    
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                  
                </form>

                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                
                <div class="col-lg-12 col-12">
          <div class="col-md-12 ">
            <!-- general form elements -->
            <div class="card card-primary">
            
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" >
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tickets</h3>
              </div>
              <!-- /.card-header -->

              <!-- /loading music events for a user -->
              <div class="card-body">
                <table class="table table-bordered table-striped" id="mytable">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Ticket Name</th>
                    <th>Ticket Price</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  ';
                  //$user_id=$_SESSION['user_id'];
                  $sql=mysqli_query($con, "SELECT * FROM event_tickets
                  WHERE user_id=$user_id and event_id='$event_id'") or die(mysqli_error($con));
  
                  $i=1;
                  while($row=mysqli_fetch_assoc($sql)){
                      $ticket_name=$row['ticket_name'];
                      $ticket_price=$row['ticket_price'];
                         
                  $output .='
                  <tr>
                  <td>'.$i.'</td>  
                    <td>'.$ticket_name.'</td>
                    <td>'.$ticket_price.'</td>
                    <td><a href="" class="btn btn-sm btn-primary">Edit</a>
                    <a href="" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                  </tr>
                  ';
                  $i=$i+1;
                }
                
                $output .='
                  </tbody>
                
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
                <!-- /.card-body -->
              </form>
            </div>
            
          </div>
          <!-- ./col -->
              </section>
              <!-- /.content -->


            </div>
            ';
            
            return $output;
            exit();
        }

        function add_speaker($con)
        {
            $user_id=$_GET['user_id'];

            $hash=Hash::unique();

            $output = '';
            $output .= '
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background:white;">
              <!-- Content Header (Page header) -->
              
              <!-- Main content -->
              <section class="content">
                <div class="row">';
                $sql=mysqli_query($con, "SELECT * FROM speakers
                WHERE user_id=$user_id") or die(mysqli_error($con));
                $row=mysqli_num_rows($sql);
       

                if($row <= 0){

                    $output.='
                    
                    <div class="col-12">
                  <form role="form" id="add_speaker" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="full_name">Full Name</label>
                      <input type="hidden"  name="user_id" value="'.$user_id.'">
                      <input type="text" class="form-control" name="full_name" placeholder="Enter Your Full Name" required>
                    </div>
                    <div class="form-group">
                    <label for="profile">Add Profile</label>
                    <textarea name="profile" class="form-control" id="editor" required>
                    </textarea>
                    </div>

                    <div class="form-group">
                    <label for="profile">Speaker Type</label>
                    <select class="form-control" name="speaker_type">
                    <option value="1">General Speaker</option>
                    <option value="1">MC</option>
                    </select>
                    </div>

                    <div class="form-group">
				  	<label for="upload_image">Profile Pic </label>
                    <hr>
                    <div class="profile-pic">
	            	<input type="file" name="file" class="form-control-file btn-primary btn-lg btn-block" accept="image/gif, image/jpeg, image/png"  required>
                    </div>
                    </div>

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  
				  </div>
                    
                  <!-- /.card-body -->

                </form>

                  </div>
                  <!-- /.col -->
                    ';
                }

                else{
                    $output.='
                    <br><br>
                    <div class="col-lg-12 col-12">
              <div class="col-md-12 ">
                <!-- general form elements -->
                <div class="card card-primary">
                
                  <!-- /.card-header -->
                  <!-- form start -->
                  <br>
                  <form role="form" >
                  <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Profile</h3>
                  </div>
                  <!-- /.card-header -->
    
                  <!-- /loading music events for a user -->
                  <div class="card-body">
                    <table class="table table-bordered table-striped" id="mytable">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>Full Name</th>
                        <th>Profile</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      ';
                      //$user_id=$_SESSION['user_id'];
                      $sql=mysqli_query($con, "SELECT * FROM speakers
                      WHERE user_id=$user_id") or die(mysqli_error($con));
      
                      $i=1;
                      while($row=mysqli_fetch_assoc($sql)){
                          $full_name=$row['full_name'];
                          $profile=$row['speaker_profile'];
                          $image_path=$row['image_path'];
                          $status=$row['status'];
                             
                      $output .='
                      <tr>
                      <td>'.$i.'</td>  
                        <td>'.$full_name.'</td>
                        <td>'.substr(strip_tags(html_entity_decode($profile)), 0, 500).'</td>
                        <td>'.$status.'</td>
                        <td><a href="dashboard.php?edit_speaker='.$hash.'&user_id='.$user_id.'" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                      </tr>
                      ';
                      $i=$i+1;
                    }
                    
                    $output .='
                      </tbody>
                    
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                    <!-- /.card-body -->
                  </form>
                </div>
                
              </div>
              <!-- ./col -->
                  </section>
                  <!-- /.content -->
    
    
                </div>
    
                </div>
                <!-- /.row -->
                ';
                }

                  
        
            return $output;
        }


        function edit_speaker($con)
        {
            $user_id=$_GET['user_id'];

            $hash=Hash::unique();

            $output = '';
            $output .= '
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background:white;">
              <!-- Content Header (Page header) -->
              
              <!-- Main content -->
              <section class="content">
                <div class="row">';
                $sql=mysqli_query($con, "SELECT * FROM speakers
                WHERE user_id=$user_id") or die(mysqli_error($con));
                $row=mysqli_num_rows($sql);
                $data=mysqli_fetch_assoc($sql);
                $fullname= $data['full_name'];
                $speaker_profile=$data['speaker_profile'];
                $speaker_type=$data['speaker_type'];
                $image_path=$data['image_path'];
       
                if($row > 0){

                    $output.='
                    <div class="col-12">
                  <form role="form" id="update_speaker" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="full_name">Full Name</label>
                      <input type="hidden"  name="user_id" value="'.$user_id.'">
                      <input type="text" class="form-control" name="full_name" placeholder="Enter Your Full Name" value="'.$fullname.'" required>
                    </div>
                    <div class="form-group">
                    <label for="profile">Profile</label>
                    <textarea name="profile" class="form-control" id="editor" required>
                    '.$speaker_profile.'
                    </textarea>
                    </div>

                    <div class="form-group">
                    <label for="profile">Speaker Type</label>
                    <select class="form-control" name="speaker_type" required>
                    <option value="1">General Speaker</option>
                    <option value="2">MC</option>
                    </select>
                    </div>

                    <div class="form-group">
				  	<label for="upload_image">Profile Pic </label>
                    <hr>
                    <div class="profile-pic" style="background-image:url(images/speaker_images/'.$image_path.')">
	            	<input type="file" name="file" class="form-control-file btn-primary btn-lg btn-block" accept="image/gif, image/jpeg, image/png" >
                    </div>
                    </div>

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="dashboard.php?speaker='.$hash.'&user_id='.$user_id.'" class="btn btn-danger">Cancel</a>
                    </div>
                  
				  </div>
                    
                  <!-- /.card-body -->

                </form>

                  </div>
                  <!-- /.col -->
                    ';
                }

                

            
            return $output;
            
        }

        function user_event($con)
        {
            $output = '';
            $output .= '
            
            <div class="content-wrapper" style="background:white;">
            <br>
   

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Messages</span>
                <span class="info-box-number">1,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bookmarks</span>
                <span class="info-box-number">410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Uploads</span>
                <span class="info-box-number">13,648</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">93,139</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <br>
        
        <div class="row">';
                $user_id=$_GET['user_id'];
                $hash= Hash::unique();
                $sql=mysqli_query($con, "SELECT * FROM all_events 
                  INNER JOIN event_category ON event_category.category_id = all_events.event_type
                  INNER JOIN venues ON all_events.id_venue=venues.venue_id  
                  WHERE all_events.user_id=$user_id") or die(mysqli_error($con));
  
                  $i=1;
                  while($row=mysqli_fetch_assoc($sql)){
                      $event_id=$row['event_id'];
                      $event_name=$row['event_name'];
                      $event_image=$row['image_path'];
                      $event_venue=$row['venue_name'];
                      $event_date=$row['start_date'];
            
                      $event_desc=$row['event_description'];
                      $status=$row['status'];
                    $output .='
                    <a href="dashboard.php?view_event_details='.$hash.'&event_id='.$event_id.'"">
          <div class="col-md-12 col-lg-4 col-xl-4 col-sm-4">
                <div class="card" style="width: 21rem;" id="">
                        <img class="card-img-top" src="images/event_images/'.$event_image.'" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">'.$event_name.'</h5><br>';
                            
                            if($status == 0){
                                $output.='
                                <div class="badge badge-danger">Inactive</div>';
                            }
                            else if ($status == 1){
                                $output.='
                                <div class="badge badge-success">Active</div>';
                            }
                            $output.='
                        </div>
                </div>           
            
          </div>
          </a>';
                  }
                  $output.='

        </div>
        <!-- /.row -->
        
    </section>
    <!-- /.content -->
  </div>
        
        
            ';
            
            return $output;
        }

        function attendees($con)
        {
            $output = '';
            $output .= '
            
            <div class="content-wrapper" style="background:white;">
            <br>
   

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Messages</span>
                <span class="info-box-number">1,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bookmarks</span>
                <span class="info-box-number">410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Uploads</span>
                <span class="info-box-number">13,648</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">93,139</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <br>
        
        <div class="row">';
                $user_id=$_GET['user_id'];
                $hash= Hash::unique();
                $sql=mysqli_query($con, "SELECT * FROM all_events 
                  INNER JOIN event_category ON event_category.category_id = all_events.event_type
                  INNER JOIN venues ON all_events.id_venue=venues.venue_id  
                  WHERE all_events.user_id=$user_id") or die(mysqli_error($con));
  
                  $i=1;
                  while($row=mysqli_fetch_assoc($sql)){
                      $event_id=$row['event_id'];
                      $event_name=$row['event_name'];
                      $event_image=$row['image_path'];
                      $event_venue=$row['venue_name'];
                      $event_date=$row['start_date'];
            
                      $event_desc=$row['event_description'];
                      $status=$row['status'];
                    $output .='
                    <a href="dashboard.php?view_attendees='.$hash.'&event_id='.$event_id.'"">
          <div class="col-md-12 col-lg-4 col-xl-4 col-sm-4">
                <div class="card" style="width: 21rem;" id="">
                        <img class="card-img-top" src="images/event_images/'.$event_image.'" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">'.$event_name.'</h5><br>';
                            
                            if($status == 0){
                                $output.='
                                <div class="badge badge-danger">Inactive</div>';
                            }
                            else if ($status == 1){
                                $output.='
                                <div class="badge badge-success">Active</div>';
                            }
                            $output.='
                        </div>
                </div>           
            
          </div>
          </a>';
                  }
                  $output.='

        </div>
        <!-- /.row -->
        
    </section>
    <!-- /.content -->
  </div>
        
        
            ';
            
            return $output;
        }

        //view attendees
        function view_attendees($con)
        {
            $output = '';
            $output .= '
            
            <div class="content-wrapper" style="background:white;">
            <br>
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- ./col -->
          <div class="col-lg-12 col-12">
            <!-- general form elements -->
        
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Attendees</h3>
              </div>
              <!-- /.card-header -->

              <!-- /loading music events for a user -->
              <div class="card-body">
                <table class="table table-bordered table-striped" id="mytable" >
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Attendee Name</th>
                    <th>Email </th>
                    <th>Ticket ID </th>
                    <th>Date Registered</th>
                  </tr>
                  </thead>
                  <tbody>
                  ';
                  $event_id=$_GET['event_id'];
                  $sql=mysqli_query($con, "SELECT * FROM attendees WHERE event_id='$event_id'") or die(mysqli_error($con));
                  $i=1;
                  while($row=mysqli_fetch_assoc($sql)){
                      $hash=Hash::unique();
                      $attendee_id=$row['attendee_id'];
                      $full_name=$row['attendee_fullname'];
                      $email=$row['attendee_email'];
                      $ticket_id=$row['ticket_id'];
                      $date_registered=$row['date_registered'];
                    
                                      
                  $output .='
                  <tr>
                  <td>'.$i.'</td>  
                    <td>'.$full_name.'</td>
                    <td>'.$email.'</td>
                    <td>'.$ticket_id.'</td>
                    <td>'.$date_registered.'</td>              
                  </tr>
                  ';
                  $i=$i+1;
                }
                
                $output .='
                  </tbody>
                
                </table>
              </div>
              <!-- /.card-body -->
        
              </form>
            </div>
            
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->

          
        </div>
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
        
            ';
            
            return $output;
        }

        //change password
        function change_password($con)
          {
             $user_id=$_GET['user_id'];
             $hash=Hash::unique();
              $output = '';
              $output .= '
              
              <div class="content-wrapper" style="background:white;">
              <br>
     
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
  
          <br>
          
          <div class="row">';
                  $sql=mysqli_query($con, "SELECT id, password FROM users WHERE
                    id=$user_id; 
                    ") or die(mysqli_error($con));
    
                    $row=mysqli_fetch_assoc($sql);
                        $password=$row['password'];
                        
                      $output .='
                      
                      <div class="col-md-3 col-sm-6 col-xl-12">
                      <form id="change_password" method="POST">
 
                      <div class="form-group">
                        <input type="hidden" name="user_id" class="form-control" value="'.$user_id.'" >
                      </div>

                      <div class="form-group">
                        <label for="event_name">Default Password</label>
                        <input type="password" class="form-control" value="'.$password.'" readonly >
                      </div>

                      <div class="form-group">
                        <label for="event_name">New Password</label>
                        <input type="password" class="form-control" name="new_password" required >
                      </div>

                      <div class="form-group">
                        <label for="event_name">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" required >
                      </div>

                     <div class="row">
                             <div class="col">
                             <button type="submit" class="btn btn-primary" >Change</button>
                             </div>
                             
                     </div><br>
             
                    
                    </form>
                    </div>';
                    

                    $output.='
  
          </div>
          <!-- /.row -->
          
      </section>
      <!-- /.content -->
    </div>
          
              ';
              
              return $output;
          }

          //function to view events
          function view_event_details($con)
          {
             $event_id=$_GET['event_id']; 
             $hash=Hash::unique();
              $output = '';
              $output .= '
              
              <div class="content-wrapper" style="background:white;">
              <br>
     
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
  
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Messages</span>
                  <span class="info-box-number">1,410</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Bookmarks</span>
                  <span class="info-box-number">410</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Uploads</span>
                  <span class="info-box-number">13,648</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Likes</span>
                  <span class="info-box-number">93,139</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <br>
          
          <div class="row">';
                  $sql=mysqli_query($con, "SELECT * FROM all_events 
                    INNER JOIN event_category ON event_category.category_id = all_events.event_type
                    INNER JOIN venues ON all_events.id_venue=venues.venue_id 
                    WHERE event_id='$event_id'; 
                    ") or die(mysqli_error($con));
    
                    $i=1;
                    while($row=mysqli_fetch_assoc($sql)){
                         $event_id=$row['event_id'];
                        $event_name=$row['event_name'];
                        $event_image=$row['image_path'];
                        $venue_id=$row['venue_id'];
                        $event_venue=$row['venue_name'];
                        $start_date=$row['start_date'];
                        $end_date=$row['end_date'];
                        $start_time=$row['start_time'];
                        $end_time=$row['end_time'];
                        $event_desc=$row['event_description'];
                        $status=$row['status'];
                      $output .='
                      
                      <div class="col-md-3 col-sm-6 col-xl-12">
                      <form>
 
                      <div class="form-group">
                        <input type="hidden" id="event_id" class="form-control" value="'.$event_id.'" >
                      </div>

                      <div class="form-group">
                                <label>Event Type</label>
                                <select name="event_type" class="form-control">
                                    <option value="'.$venue_id.'">'.$event_venue.'</option>;';
                                    $query=mysqli_query($con, "SELECT * FROM venues") or die(mysqli_error($con));
                                    while($row=mysqli_fetch_assoc($query)){
                                        $venue_id= $row['venue_id'];
                                        $venue_name= $row['venue_name'];
                                        $output .='
                                            <option value='.$venue_id.'>'.$venue_name.'</option>;
                                        ';
                                    }
                                    $output .='
                                </select>
                        </div>
                      
                      <div class="form-group">
                        <label for="event_name">Event Name</label>
                        <input type="text" class="form-control" value="'.$event_name.'" >
                      </div>
 
              
                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" rows="3" >'.$event_desc.'</textarea>
                      </div>
 
                      <div class="row">
                             <div class="col">
                             <label for="event_name">Start Date</label>
                             <input type="text" class="form-control" value="'.$start_date.'" >
                             </div>
                             <div class="col">
                             <label for="event_name">End Date</label>
                             <input type="text" class="form-control" value="'.$end_date.'" >
                             </div>
                     </div><br>
 
                     <div class="row">
                             <div class="col">
                             <label for="event_name">Start Time</label>
                             <input type="text" class="form-control" value="'.$start_time.'" >
                             </div>
                             <div class="col">
                             <label for="event_name">Closing Time</label>
                             <input type="text" class="form-control" value="'.$end_time.'" >
                             </div>
                     </div><br>
 
                     <div class="row">
                             <div class="col">
                             <button type="button" class="btn btn-primary" >Update</button>
                             <a href="dashboaard.php?my_events='.$hash.'" class="btn btn-outline-primary"><i class="fa fa-arrow-left"></i>Back</a>
                             </div>
                             
                     </div><br>
             
                      
                      
                    </form>
                    </div>';
                    }

                    $output.='
  
          </div>
          <!-- /.row -->
          
      </section>
      <!-- /.content -->
    </div>
          
              ';
              
              return $output;
          }

        //verifying ticket
        function verify_ticket($con)
        {
            $output = '';
            $output .= '
            
            <div class="content-wrapper" style="background:white;">
            <br>
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- ./col -->
          <div class="col-lg-12 col-12">
          <div class="col-md-12 ">
            <!-- general form elements -->
            <div class="card card-primary">
              
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" >
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Events</h3>
              </div>
              <!-- /.card-header -->

              <!-- /loading music events for a user -->
              <div class="card-body">
                <table class="table table-bordered table-striped" id="mytable">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Event Description</th>
                    <th>Event Venue</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  ';
                  $user_id=$_SESSION['user_id'];
                  $sql=mysqli_query($con, "SELECT * FROM all_events 
                  INNER JOIN event_category ON event_category.category_id = all_events.event_type
                  INNER JOIN venues ON all_events.id_venue=venues.venue_id  
                  WHERE all_events.user_id=$user_id") or die(mysqli_error($con));
  
                  $i=1;
                  while($row=mysqli_fetch_assoc($sql)){
                      $hash=Hash::unique();
                      $event_id=$row['event_id'];
                      $event_name=$row['event_name'];
                      $event_desc=$row['event_description'];
                      $event_venue=$row['venue_name'];
                      $start_date=$row['start_date'];
                                      
                  $output .='
                  <tr>
                  <td>'.$i.'</td>  
                    <td>'.$event_name.'</td>
                    <td>'.$event_desc.'</td>
                    <td>'.$event_venue.'</td>
              
                    <td><a href="dashboard.php?scan_event_ticket='.$hash.'&user_id='.$user_id.'&event_id='.$event_id.'"class="btn btn-sm btn-success">Verify Ticket </a></td>
                  </tr>
                  ';
                  $i=$i+1;
                }
                
                $output .='
                  </tbody>
                
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
                <!-- /.card-body -->
              </form>
            </div>
            
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->

          
        </div>
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
        
            ';
            
            return $output;
        }


        function scan_ticket($con)
        {
            $event_id=$_GET['event_id'];
            
            $output = '';
            $output .= '
            
            
            <div class="content-wrapper" style="background:white;">
            <br>
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="event_id" id='.$event_id.'></div>
        <div class="container">
        <center>
        <button type="button" id="start_scan" class="btn btn-primary">Start Scan</button>
        </center>
        </div>

        <style>
        #preview{
           width:500px;
           height: 500px;
           margin:0px auto;
        }
        </style>
        
        <video id="preview"></video>
    
          
        </div>
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
        
            ';
            ?>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/schmich/instascan-builds@master/instascan.min.js"></script>

            <?php
            
            return $output;
        }

        function user_sales($con){
            
            $output='';
            $output.='
            <div class="content-wrapper" style="background:white;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                 
                 
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
        
            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">';
                      $user_id=$_SESSION['user_id'];
                      $sql=mysqli_query($con, "SELECT * FROM all_events 
                      INNER JOIN event_category ON event_category.category_id = all_events.event_type 
                      WHERE all_events.user_id=$user_id");
                      $count=mysqli_num_rows($sql);

                      $output.='

                        <h3>'.$count.'</h3>
                        <p>Total Number of Events</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
        
                        <p>Total Revenue</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3>44</h3>
        
                        <p>User Registrations</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>65</h3>
        
                        <p>Unique Visitors</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-chart-pie mr-1"></i>
                          Sales
                        </h3>
                        <div class="card-tools">
                          <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                              <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                            </li>
                          </ul>
                        </div>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content p-0">
                          <!-- Morris chart - Sales -->
                          <div class="chart tab-pane active" id="revenue-chart"
                               style="position: relative; height: 300px;">
                              <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                           </div>
                          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                            <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                          </div>  
                        </div>
                      </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
    
        
                  
                  </section>
                  <!-- /.Left col -->
                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                  
                  <section class="col-lg-12 connectedSortable">
        
                    <!-- Map card -->
                    <div class="card bg-gradient-primary">
                      <div class="card-header border-0">
                        <h3 class="card-title">
                          <i class="fas fa-map-marker-alt mr-1"></i>
                          Visitors
                        </h3>
                        <!-- card tools -->
                        <div class="card-tools">
                          <button type="button"
                                  class="btn btn-primary btn-sm daterange"
                                  data-toggle="tooltip"
                                  title="Date range">
                            <i class="far fa-calendar-alt"></i>
                          </button>
                          <button type="button"
                                  class="btn btn-primary btn-sm"
                                  data-card-widget="collapse"
                                  data-toggle="tooltip"
                                  title="Collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <div class="card-body">
                        <div id="world-map" style="height: 250px; width: 100%;"></div>
                      </div>
                      <!-- /.card-body-->
                      <div class="card-footer bg-transparent">
                        <div class="row">
                          <div class="col-4 text-center">
                            <div id="sparkline-1"></div>
                            <div class="text-white">Visitors</div>
                          </div>
                          <!-- ./col -->
                          <div class="col-4 text-center">
                            <div id="sparkline-2"></div>
                            <div class="text-white">Online</div>
                          </div>
                          <!-- ./col -->
                          <div class="col-4 text-center">
                            <div id="sparkline-3"></div>
                            <div class="text-white">Sales</div>
                          </div>
                          <!-- ./col -->
                        </div>
                        <!-- /.row -->
                      </div>
                    </div>
                    <!-- /.card -->
        
                    <!-- solid sales graph -->
                    <div class="card bg-gradient-info">
                      <div class="card-header border-0">
                        <h3 class="card-title">
                          <i class="fas fa-th mr-1"></i>
                          Sales Graph
                        </h3>
        
                        <div class="card-tools">
                          <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body">
                        <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer bg-transparent">
                        <div class="row">
                          <div class="col-4 text-center">
                            <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                                   data-fgColor="#39CCCC">
        
                            <div class="text-white">Mail-Orders</div>
                          </div>
                          <!-- ./col -->
                          <div class="col-4 text-center">
                            <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                                   data-fgColor="#39CCCC">
        
                            <div class="text-white">Online</div>
                          </div>
                          <!-- ./col -->
                          <div class="col-4 text-center">
                            <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                                   data-fgColor="#39CCCC">
        
                            <div class="text-white">In-Store</div>
                          </div>
                          <!-- ./col -->
                        </div>
                        <!-- /.row -->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
        
                    <!-- Calendar -->
                    <div class="card bg-gradient-success">
                      <div class="card-header border-0">
        
                        <h3 class="card-title">
                          <i class="far fa-calendar-alt"></i>
                          Calendar
                        </h3>
                        <!-- tools card -->
                        <div class="card-tools">
                          <!-- button with a dropdown -->
                          <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                              <i class="fas fa-bars"></i></button>
                            <div class="dropdown-menu float-right" role="menu">
                              <a href="#" class="dropdown-item">Add new event</a>
                              <a href="#" class="dropdown-item">Clear events</a>
                              <div class="dropdown-divider"></div>
                              <a href="#" class="dropdown-item">View calendar</a>
                            </div>
                          </div>
                          <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                          </button>
                        </div>
                        <!-- /. tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body pt-0">
                        <!--The calendar -->
                        <div id="calendar" style="width: 100%"></div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </section>
                  <!-- right col -->
                </div>
                <!-- /.row (main row) -->
              </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
          </div>
            ';

            return $output;
        }

     



      

        function categories($user, $con)
        {
            $data = $user->data();
            $output = '';
            $output .='
                <div class="widget has-shadow">
                    <div class="widget-header bordered no-actions d-flex align-items-center">
                        <div class="col-xl-6">
                            <h4>Service Categories</h4>
                        </div>

                        <div class="col-xl-6 offset-xl-4 offset-sm-0">
                            <button class="btn btn-gradient-01 category">Add New Category</button>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div id="category_table"></div>
                    </div>
                </div>

                <div id="category" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" id="new_category">
                                <div class="modal-header">
                                    <h4 class="modal-title">New Category</h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                        <span class="sr-only">close</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" required name="category" class="form-control" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="categories" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <span id="gories"></span>
                        </div>
                    </div>
                </div>
            ';
            return $output;
        }


        function allevents(){
            $output ='';
            $output .='
            <h1>All Events</h1>
            ';

            return $output;
        }

        function events($con)
        {
            $unique=Hash::unique();
            $output = '';
            $output .= '
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admin-page.php">Home</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                      </ol>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->
              </section>
          
              <!-- Main content -->
              <section class="content">
                <div class="row">
                  <div class="col-12">
                    
                      <!-- /.card-header -->
                    <!-- /.card -->
          
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Users Table</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped" id="mytable">
                          <thead>
                          <tr>
                            <th>id</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          ';
                          $sql=mysqli_query($con, "SELECT * FROM users") or die(mysqli_error($con));
                          $i=1;
                          while($row=mysqli_fetch_assoc($sql)){
                              $id=$row['id'];
                              $fname=$row['fname'];
                              $lname=$row['lname'];
                              $username=$row['username'];
                              $password=$row['password'];
                              $contact=$row['contact'];
                              $role=$row['role'];
                          
                          $output .='
                          <tr>
                          <td>'.$i.'</td>  
                            <td>'.$fname.'.'.$lname.'</td>
                            <td>'.$username.'</td>
                            <td>'.$password.'</td>
                            <td>'.$contact.'</td>
                            <td>'.$role.'</td>
                            <td><a href="?edit='.$unique.'&uid='.$id.'"class="btn btn-block btn-primary" id="'.$id.'" </a>Edit</td>
                          </tr>
                          ';
                          $i=$i+1;
                        }
                        
                        $output .='
                          </tbody>
                        
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </section>
              <!-- /.content -->
            </div>
            
            ';
            return $output;
        }

        function admin_dashboard($con){
            $output ='';

            $output.='
            
            <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                <?php 
                $sql=mysqli_query($con, "SELECT * FROM all_events");
                $count=mysqli_num_rows($sql);
                echo $count;
                ?>
                </h3>

                <p>Upcoming Events</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php 
                $sql=mysqli_query($con, "SELECT * FROM users WHERE role !="Administrator");
                $count=mysqli_num_rows($sql);
                echo $count;
                ?></h3>

                <p>Registered Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php 
                $sql=mysqli_query($con, "SELECT * FROM venues");
                $count=mysqli_num_rows($sql);
                echo $count;?>
                </h3>

                <p>Venues</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                <?php 
                $sql=mysqli_query($con, "SELECT * FROM speakers");
                $count=mysqli_num_rows($sql);
                echo $count;?>
                </h3>

                <p>Speakers</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

          
              
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-12 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitors
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button"
                          class="btn btn-primary btn-sm daterange"
                          data-toggle="tooltip"
                          title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button"
                          class="btn btn-primary btn-sm"
                          data-card-widget="collapse"
                          data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
            

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu float-right" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  ';
        }

        
        function users($con)
        {
            $unique=Hash::unique();
            $output = '';
            $output .= '
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admin-page.php">Home</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                      </ol>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->
              </section>
          
              <!-- Main content -->
              <section class="content">
                <div class="row">
                  <div class="col-12">
                    
                      <!-- /.card-header -->
                    <!-- /.card -->
          
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Users Table</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped" id="mytable">
                          <thead>
                          <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          ';
                          $sql=mysqli_query($con, "SELECT * FROM users") or die(mysqli_error($con));
                          $i=1;
                          while($row=mysqli_fetch_assoc($sql)){
                              $id=$row['id'];
                              $fname=$row['fname'];
                              $lname=$row['lname'];
                              $username=$row['username'];
                              $password=$row['password'];
                              $contact=$row['contact'];
                              $role=$row['role'];
                          
                          $output .='
                          <tr>
                          <td>'.$i.'</td>  
                            <td>'.$fname.'.'.$lname.'</td>
                            <td>'.$username.'</td>
                            <td>'.$password.'</td>
                            <td>'.$contact.'</td>
                            <td>'.$role.'</td>
                            <td>
                            <a href="admin-page.php?edit-user='.$unique.'&uid='.$id.'" class="btn btn-sm btn-primary" id="'.$id.'">Edit</a>
                            <a href="admin-page.php?remove-user='.$unique.'&uid='.$id.'"class="btn btn-sm btn-danger" id="'.$id.'">Remove</a>
                            </td>
                            
                          </tr>
                          ';
                          $i=$i+1;
                        }
                        
                        $output .='
                          </tbody>
                        
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </section>
              <!-- /.content -->
            </div>
            
            ';
            return $output;
            
        }

        function venues($con)
        {
            $unique=Hash::unique();
            $output = '';
            $output .= '
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                
                  </div>
                </div><!-- /.container-fluid -->
              </section>
          
              <!-- Main content -->
              <section class="content">
                <div class="row">
                  <div class="col-12">
                    
                      <!-- /.card-header -->
                    <!-- /.card -->
          
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Venues</h3>
                        <a href="admin-page.php?add_venue='.$unique.'" class="btn btn-outline-primary float-right">Add Venue</a>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped" id="mytable">
                          <thead>
                          <tr>
                            <th>ID</th>
                            <th>Venue Name</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          ';
                          $sql=mysqli_query($con, "SELECT * FROM venues") or die(mysqli_error($con));
                          $i=1;
                          while($row=mysqli_fetch_assoc($sql)){
                              $id=$row['venue_id'];
                              $venue_name=$row['venue_name'];
                              $venue_capacity=$row['venue_capacity'];
                              $venue_location=$row['venue_location'];
                          
                          $output .='
                          <tr>
                          <td>'.$i.'</td>  
                            <td>'.$venue_name.'</td>
                            <td>'.$venue_capacity.'</td>
                            <td>'.strip_tags(html_entity_decode($venue_location)).'</td>
                            <td>
                            <a href="admin-page.php?deactivate_venue='.$unique.'&uid='.$id.'" class="btn btn-sm btn-primary" id="'.$id.'">Deactivate</a>
                            <a href="admin-page.php?remove_venue='.$unique.'&uid='.$id.'"class="btn btn-sm btn-danger" id="'.$id.'">Remove</a>
                            </td>
                            
                          </tr>
                          ';
                          $i=$i+1;
                        }
                        
                        $output .='
                          </tbody>
                        
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </section>
              <!-- /.content -->
            </div>
            
            ';
            return $output;
            
            
        }

        function add_venue($con)
        {

            $hash=Hash::unique();

            $output = '';
            $output .= '
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background:white;">
              <!-- Content Header (Page header) -->
              
              <!-- Main content -->
              <section class="content">
                <div class="row">';

                    $output.='
                    <div class="col-12">
                  <form role="form" id="add_venue" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="full_name">Venue Name</label>
                      <input type="text" class="form-control" name="venue_name" placeholder="venue Name"  required>
                    </div>

                    <div class="form-group">
                      <label for="full_name">Capacity</label>
                      <input type="text" class="form-control" name="venue_capacity" placeholder="Capacity.." required>
                    </div>

                    <div class="form-group">
                    <label for="profile">Location</label>
                    <textarea name="venue_location" class="form-control" id="editor" required>
                    </textarea>
                    </div>

                    <div class="form-group">
				  	<label for="upload_image">Cover Image</label>
                    <hr>
                    <div class="profile-pic">
	            	<input type="file" name="file" class="form-control-file btn-primary btn-lg btn-block" accept="image/gif, image/jpeg, image/png" >
                    </div>
                    </div>

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="admin-page.php?venue='.$hash.'" class="btn btn-danger">Cancel</a>
                    </div>
                  
				  </div>
                    
                  <!-- /.card-body -->

                </form>

                  </div>
                  <!-- /.col -->
                    ';
                

                

            
            return $output;
            
        }

        //function to view events
        function view_events($con)
        {
            $hash=Hash::unique();
            $output = '';
            $output .= '
            
            <div class="content-wrapper" style="background:white;">
            <br>
   

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Messages</span>
                <span class="info-box-number">1,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bookmarks</span>
                <span class="info-box-number">410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Uploads</span>
                <span class="info-box-number">13,648</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">93,139</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <br>
        
        <div class="row">';
                $sql=mysqli_query($con, "SELECT * FROM all_events 
                  INNER JOIN event_category ON event_category.category_id = all_events.event_type
                  INNER JOIN venues ON all_events.id_venue=venues.venue_id  
                  ") or die(mysqli_error($con));
  
                  $i=1;
                  while($row=mysqli_fetch_assoc($sql)){
                        $event_id=$row['event_id'];
                      $event_name=$row['event_name'];
                      $event_image=$row['image_path'];
                      $event_venue=$row['venue_name'];
                      $start_date=$row['start_date'];
                      $event_desc=$row['event_description'];
                      $status=$row['status'];
                    $output .='
                    <a href="admin-page.php?view_event_details='.$hash.'&event_id='.$event_id.'"">
          <div class="col-md-12 col-lg-4 col-xl-4 col-sm-4">
                <div class="card" style="width: 21rem;" id="">
                        <img class="card-img-top" src="images/event_images/'.$event_image.'" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">'.$event_name.'</h5><br>';
                            
                            if($status == 0){
                                $output.='
                                <div class="badge badge-danger">Inactive</div>';
                            }
                            else if ($status == 1){
                                $output.='
                                <div class="badge badge-success">Active</div>';
                            }
                            $output.='
                        </div>
                </div>           
            
          </div>
          </a>';
                  }
                  $output.='

        </div>
        <!-- /.row -->
        
    </section>
    <!-- /.content -->
  </div>
        
            ';
            
            return $output;
        }

         //function to view organizer events
         function view_event_details_admin($con)
         {
            $event_id=$_GET['event_id']; 
            $hash=Hash::unique();
             $output = '';
             $output .= '
             
             <div class="content-wrapper" style="background:white;">
             <br>
    
 
     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
 
       <div class="row">
           <div class="col-md-3 col-sm-6 col-12">
             <div class="info-box">
               <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
 
               <div class="info-box-content">
                 <span class="info-box-text">Messages</span>
                 <span class="info-box-number">1,410</span>
               </div>
               <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
           </div>
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
             <div class="info-box">
               <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
 
               <div class="info-box-content">
                 <span class="info-box-text">Bookmarks</span>
                 <span class="info-box-number">410</span>
               </div>
               <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
           </div>
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
             <div class="info-box">
               <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
 
               <div class="info-box-content">
                 <span class="info-box-text">Uploads</span>
                 <span class="info-box-number">13,648</span>
               </div>
               <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
           </div>
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
             <div class="info-box">
               <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
 
               <div class="info-box-content">
                 <span class="info-box-text">Likes</span>
                 <span class="info-box-number">93,139</span>
               </div>
               <!-- /.info-box-content -->
             </div>
             <!-- /.info-box -->
           </div>
           <!-- /.col -->
         </div>
         <!-- /.row -->
         <br>
         
         <div class="row">';
                 $sql=mysqli_query($con, "SELECT * FROM all_events 
                   INNER JOIN event_category ON event_category.category_id = all_events.event_type
                   WHERE event_id='$event_id'; 
                   ") or die(mysqli_error($con));
   
                   $i=1;
                   while($row=mysqli_fetch_assoc($sql)){
                        $event_id=$row['event_id'];
                       $event_name=$row['event_name'];
                       $event_image=$row['image_path'];
                       $event_venue=$row['event_venue'];
                       $start_date=$row['event_date'];
                       $start_time=$row['start_time'];
                       $end_time=$row['end_time'];
                       $event_desc=$row['event_description'];
                       $status=$row['status'];
                     $output .='
                     
                     <div class="col-md-3 col-sm-6 col-xl-12">
                     <form>

                     <div class="form-group">
                       <input type="hidden" id="event_id" class="form-control" value="'.$event_id.'" readonly>
                     </div>
                     
                     <div class="form-group">
                       <label for="event_name">Event Name</label>
                       <input type="text" class="form-control" value="'.$event_name.'" readonly>
                     </div>

                     <div class="form-group">
                       <label for="event_venue">Event Venue</label>
                       <input type="text" class="form-control" value="'.$event_venue.'" readonly>
                     </div>

                     <div class="form-group">
                       <label for="exampleFormControlTextarea1">Description</label>
                       <textarea class="form-control" rows="3" readonly>'.$event_desc.'</textarea>
                     </div>

                     <div class="row">
                            <div class="col">
                            <label for="event_name">Start Date</label>
                            <input type="text" class="form-control" value="'.$start_date.'" readonly>
                            </div>
                            
                    </div><br>

                    <div class="row">
                            <div class="col">
                            <label for="event_name">Start Time</label>
                            <input type="text" class="form-control" value="'.$start_time.'" readonly>
                            </div>
                            <div class="col">
                            <label for="event_name">Closing Time</label>
                            <input type="text" class="form-control" value="'.$end_time.'" readonly>
                            </div>
                    </div><br>

                    <div class="row">
                            <div class="col">
                            <button type="button" class="btn btn-primary" id="approve_event">Approve</button>
                            <button type="button" class="btn btn-danger" id="decline_event">Decline</button>
                            <a href="admin-page.php?event_mgm='.$hash.'" class="btn btn-outline-primary"><i class="fa fa-arrow-left"></i>Back</a>
                            </div>
                            
                    </div><br>
            
                     
                     
                   </form> ';
                   }
                   $output.='
 
         </div>
         <!-- /.row -->
         
     </section>
     <!-- /.content -->
   </div>
         
             ';
             
             return $output;
         }
 


        function view_speakers($con)
        {
        
            $hash=Hash::unique();

            $output = '';
            $output .= '

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background:white;">
              <!-- Content Header (Page header) -->
              
              <!-- Main content -->
              <section class="content">
              <br>
              <h5>All Speakers</h5>
              <br>

                <div class="row">';
                $sql=mysqli_query($con, "SELECT * FROM speakers") or die(mysqli_error($con));
      
                      while($row=mysqli_fetch_assoc($sql)){
                          $speaker_id=$row['speaker_id'];
                          $full_name=$row['full_name'];
                          $speaker_type=$row['speaker_type'];
                          $profile=$row['speaker_profile'];
                          $image_path=$row['image_path'];
                          $status=$row['status'];
            
                    $output.='
                    <br><br>
                    <div class="col-lg-3 col-xl-3">
                        <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="images/speaker_images/'.$image_path.'"
                            alt="User profile picture">
                        </div>

                <h3 class="profile-username text-center" >'.$full_name.'</h3>';
                if($speaker_type ==1){
                    $output.='
                <p class="text-muted text-center">General Speaker</p>';
                }
                else{
                    $output.='
                    <p class="text-muted text-center">MC</p>';
                }

                if($status==1){
                    $output.='
                    <p class="text-muted text-center" style="color:green !important;">Active</p>';
                }
                else{
                    $output.='
                    <p class="text-muted text-center" style="color:red !important;">Inactive</p>';
                }

                if($status==1){
                    $output.='
                    <button type="button" id= "'.$speaker_id.'" class="decline btn btn-danger btn-block">Decline</button>';
                }

                else{
                    $output.='
                    <button type="button" id="'.$speaker_id.'" class="approve btn btn-outline-primary btn-block">Approve</button>';
                }

                $output.='
                
              </div>
              <!-- /.card-body -->
            </div>';
                      }

                      $output.='


            </div>

                  </section>
                  <!-- /.content -->
    

                </div>
                <!-- /.row -->
                ';
    
            return $output;
        }


       
        function edit($con,$user)
        {
            $id=$user;
            $select =mysqli_query($con, "SELECT * FROM users WHERE id=$id");
            $row=mysqli_fetch_assoc($select);
            $username=$row['username'];
            $firstname=$row['fname'];
            $lastname=$row['lname'];
            $lastname=$row['lname'];
            $contact=$row['contact'];
            $output ='';
            $output .='
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">

            <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update User Data</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" id="update_user">
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" name="username"  value="'.$username.'" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">First Name</label>
                  <input type="text" class="form-control" name="fname" value="'.$firstname.'" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Last Name</label>
                  <input type="text" class="form-control" name="lname" value="'.$lastname.'" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="password" class="form-control" name="oldpassword" placeholder="Old Password" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" name="newpassword" placeholder="New Password" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Contact</label>
                  <input type="text" class="form-control" name="contact" value="'.$contact.'">
                </div>
                <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="user_role">
                        <option selected disabled>Choose</option>
                          <option>Administrator</option>
                          <option>Customer</option>
                        </select>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              <div class="alert alert-danger" role="alert" id="message" style="display:none;">
              <div>
            </form>
          </div>
          <!-- /.card -->
          </div>
          </section>
            ';
            return $output;
        }

    

        
    }
?>