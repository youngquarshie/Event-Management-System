<?php
	
	require '../includes/connect.php';
	require '../assets/Hash.php';
	require '../assets/sanitize.php';
	require_once '../vendor/autoload.php';

	include '../phpqrcode/qrlib.php'; 
	//include '../phpqrcode/qrconfig.php'; 
	
	$text = escape($_REQUEST['text']);
	$user_id = Hash::unique();
	
	if($text == "loggedin")
	{
		$success=false;

		$username = escape($_POST['username']);
		$password = escape($_POST['password']);

$username=htmlspecialchars($_POST['username']);
$username=mysqli_real_escape_string($con, $_POST['username']);

$password=htmlspecialchars($_POST['password']);
$password=mysqli_real_escape_string($con, $_POST['password']);

$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND role='Administrator' AND not deleted;");
while($row = mysqli_fetch_array($result))
{

	$success = true;
	$db_password=$row['password'];
	if(password_verify($password, $db_password)){
	$user_id = $row['id'];
	$fname = $row['fname'];
	$lname = $row['lname'];
	$role= $row['role'];

	$success = true;
	}

	else{
		echo 'incorrect';
	}

	
	
}
if($success == true)
{	
	
	$_SESSION['admin_sid']=session_id();
	$_SESSION['user_id'] = $user_id;
	$_SESSION['role'] = $role;
	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;

	echo "admin";
	
}
else
{
	$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND role='Customer' AND not deleted;");
	while($row = mysqli_fetch_array($result))
	{
		//$success = true;
		$db_password=$row['password'];
		if(password_verify($password, $db_password)){
		$user_id = $row['id'];
		$fname = $row['fname'];
		$lname = $row['lname'];
		$role= $row['role'];
	
		$success = true;

		}

		else{
			echo 'incorrect';
		}
	}


	if($success == true)
	{
		
		$_SESSION['customer_sid']=session_id();
		$_SESSION['user_id'] = $user_id;
		$_SESSION['role'] = $role;
		$_SESSION['name'] = $name;	
		
		echo "cust";	
		
	}
	
}
	}

	


	elseif($text=="update_user"){
		$username = escape($_POST['username']);
		$fname = escape($_POST['fname']);
		$lname = escape($_POST['lname']);
		$oldpassword = escape($_POST['oldpassword']);
		$newpassword = escape($_POST['newpassword']);
		$user_role = escape($_POST['user_role']);
		$contact = escape($_POST['contact']);
		$myid = $_SESSION['user_id'];
		
		$select=mysqli_query($con, "SELECT password from users WHERE id=$myid");
		$row=mysqli_fetch_assoc($select);
		$dbpass=$row['password'];

		if(!isset($_POST['username']) || !isset($_POST['username']) || !isset($_POST['username']) || !isset($_POST['username']) ||
		!isset($_POST['username']) || !isset($_POST['username'])){
			echo "All fields must be completed";
			echo "</br>";
		}
		else{
			if($oldpassword!==$dbpass){
				echo "Old Password is incorrect, check and try again";
				echo "</br>";
			}
			
			if(preg_match("/^[a-zA-Z]+$/", $contact) || strlen($contact) > 11){
				echo "Contact field contains alphabet or the numbers are more than 10 ";
				echo "</br>";
			}

			if(preg_match("/^[0-9]+$/", $fname) || preg_match("/^[0-9]+$/", $lname)) {
				echo "First Name or Last Name cannot contain digits ";
				echo "</br>";
			}
			else{
				$hash=password_hash($newpassword, PASSWORD_DEFAULT);
				$update=mysqli_query($con, "UPDATE users SET username='$username', fname='$fname', 
				lname='$lname', contact='$contact', password='$hash' WHERE id='$myid'") or die(mysqli_error($con));

				if($update){
					echo 'success';
					header("location:admin.php?users=$salt");
				}
			}
		}
		
	}


	//removing events which has already been held
	else if($text == "jk3454jh43435"){
		$date = Date('Y-m-d');

		$check=mysqli_query($con, "SELECT * FROM all_events");
		while($row=mysqli_fetch_array($check)){
			if($date >= $row['event_date']){
				$id= $row['event_id'];
				mysqli_query($con,"UPDATE all_events SET status = 3 WHERE event_id='$id'");
			}
			else{
				//echo "5";
			}
			
		}
		
		exit();
	}


	//events occuring today
	else if($text == "bvdgdhjf483"){
		$date = Date('Y-m-d');

		$check=mysqli_query($con, "SELECT * FROM all_events");
		while($row=mysqli_fetch_array($check)){
			if($date == $row['event_date']){
				$id= $row['event_id'];
				mysqli_query($con,"UPDATE all_events SET status = 2 WHERE event_id='$id'");
			}
			else{
				//echo "5";
			}
			
		}
		
		exit();
	}


	//events occuring today
	else if($text == "approve-event"){
		$id=$_POST['event_id'];
		$update=mysqli_query($con, "UPDATE all_events SET status = 1 WHERE event_id='$id'");
		if($update){
			echo "success";
		}
		
		exit();
	}

	else if($text == "decline-event"){
		$id=$_POST['event_id'];
		$update=mysqli_query($con, "UPDATE all_events SET status = 0 WHERE event_id='$id'");
		if($update){
			echo "success";
		}
		
		exit();
	}

	else if($text == "approve_speaker"){
		$speaker_id=$_POST['id'];
		$update=mysqli_query($con, "UPDATE speakers SET status = 1 WHERE speaker_id='$speaker_id'");
		if($update){
			echo "success";
		}
		
		exit();
	}

	else if($text == "decline_speaker"){
		$speaker_id=$_POST['id'];
		$update=mysqli_query($con, "UPDATE speakers SET status = 0 WHERE speaker_id='$speaker_id'");
		if($update){
			echo "success";
		}
		
		exit();
	}


	//verifying qr code
	else if($text == "verify_qrcode")
	{
		
		$salt_id = Hash::unique();
		$event_id= escape($_POST['event_id']);
		$qrcode=escape($_POST['qr_code']);
		//echo $qrcode;
		
			    try
			    {
						$check=mysqli_query($con, "SELECT * FROM attendees 
						WHERE event_id='$event_id' AND ticket_id='$qrcode'") or 
						die(mysqli_error($con));
						
						$check_rows=mysqli_num_rows($check);
						
						if($check_rows>0){
							$data=mysqli_fetch_assoc($check);
							if($data['ticket_status']==0){
								$update=mysqli_query($con, "UPDATE attendees 
						SET ticket_status=1 WHERE event_id='$event_id' AND ticket_id='$qrcode'") or 
						die(mysqli_error($con));
						if($update){
							
							echo "success";
							exit();
						}
							}
							else{
								echo "already";
								exit();
							}
							
						}
						else{
							echo "invalid";
							exit();
						}
					
			    	
				}
				catch(Exception $e)
			    {
						echo $e;
			    }
			
		
	}

	//adding speaker to the database
	else if($text == "add_speaker")
	{
		
		$salt_id = Hash::unique();
		$user_id = escape($_POST['user_id']);
		$full_name=escape($_POST['full_name']);
		$profile=escape($_POST['profile']);
		$speaker_type=escape($_POST['speaker_type']);
		$status=0;
		$image = $_FILES['file']['name'];

			$target_dir = "../images/speaker_images/";
			$target_file = basename($_FILES["file"]["name"]);
			$image_name = "";
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$extensions_arr = array("png","jpg","jpeg","JPEG","JPG");
			if( in_array($imageFileType,$extensions_arr) ){
				$checker = "1";
				$image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
			    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
			    $image_name= $salt_id.'.'.$imageFileType;
			    $upload = $target_dir .$image_name;
			    move_uploaded_file($_FILES['file']['tmp_name'],$upload);
			    try
			    {
						mysqli_query($con, "INSERT INTO speakers
						(speaker_id, user_id, full_name, speaker_profile,speaker_type, image_path, status, date_registered) 
						VALUES ('$salt_id', $user_id, '$full_name','$profile',$speaker_type,'$image_name', '$status', NOW())") or 
						die(mysqli_error($con));
						
						echo 'success';
					

			    	
			    }catch(Exception $e)
			    {

			    }
			} else 
			{
				echo 'unknown_file_type';
			}
		
	}


	//adding speaker to the database
	else if($text == "add_venue")
	{
		
		$salt_id = Hash::unique();
		$venue_name=escape($_POST['venue_name']);
		$venue_location=escape($_POST['venue_location']);
		$capacity=escape($_POST['venue_capacity']);
		$status=0;
		$image = $_FILES['file']['name'];

			$target_dir = "../images/venue_images/";
			$target_file = basename($_FILES["file"]["name"]);
			$image_name = "";
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$extensions_arr = array("png","jpg","jpeg","JPEG","JPG");
			if( in_array($imageFileType,$extensions_arr) ){
				$checker = "1";
				$image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
			    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
			    $image_name= $salt_id.'.'.$imageFileType;
			    $upload = $target_dir .$image_name;
			    move_uploaded_file($_FILES['file']['tmp_name'],$upload);
			    	try
			    	{
						mysqli_query($con, "INSERT INTO venues
						(venue_id, venue_name, venue_capacity, venue_location, image_path) 
						VALUES ('$salt_id','$venue_name',$capacity,'$venue_location','$image_name')") or 
						die(mysqli_error($con));
						
						echo 'success';
			    	
					}

					catch(Exception $e)
			    	{
						echo $e;
			    	}
			}
			
			else 
			{
				echo 'unknown_file_type';
			}
		
	}


	//update speaker to the database
	else if($text == "update_speaker")
	{

		
		$salt_id = Hash::unique();
		$user_id = escape($_POST['user_id']);
		$full_name=escape($_POST['full_name']);
		$profile=escape($_POST['profile']);
		
		$speaker_type=escape($_POST['speaker_type']);
		$status=0;
		$image = $_FILES['file']['name'];
		if(empty($image)){

			try
			    {
					mysqli_query($con, "UPDATE speakers SET full_name= '$full_name', speaker_profile='$profile', speaker_type='$speaker_type' 
					WHERE user_id=$user_id") or die(mysqli_error($con));
						
					echo 'success';
					
				}
				catch(Exception $e)
			    {
					echo 'error';
			    }
		}

		else{
			$target_dir = "../images/speaker_images/";
			$target_file = basename($_FILES["file"]["name"]);
			$image_name = "";
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$extensions_arr = array("png","jpg","jpeg","JPEG","JPG");
			if( in_array($imageFileType,$extensions_arr) ){
				$checker = "1";
				$image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
			    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
				$image_name= $salt_id.'.'.$imageFileType;
			    $upload = $target_dir .$image_name;
			    move_uploaded_file($_FILES['file']['tmp_name'],$upload);
			    try
			    {
					mysqli_query($con, "UPDATE speakers
					SET full_name='$full_name', speaker_profile='$profile', speaker_type='$speaker_type', image_path='$image_name' 
					WHERE user_id=$user_id") or die(mysqli_error($con));
						
					echo 'success';
					

				}
				catch(Exception $e)
			    {

			    }
			} 
			
			else 
			{
				echo 'unknown_file_type';
			}
		}

			$target_dir = "../images/speaker_images/";
			$target_file = basename($_FILES["file"]["name"]);
			$image_name = "";
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$extensions_arr = array("png","jpg","jpeg","JPEG","JPG");
			if( in_array($imageFileType,$extensions_arr) ){
				$checker = "1";
				$image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
			    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
			    $image_name= $salt_id.'.'.$imageFileType;
			    $upload = $target_dir .$image_name;
			    move_uploaded_file($_FILES['file']['tmp_name'],$upload);
			    try
			    {
						mysqli_query($con, "UPDATE speakers
						SET full_name= '$full_name', speaker_profile='$profile', speaker_type='$speaker_type', image_path, status, date_registered) 
						VALUES ('$salt_id', $user_id, '$full_name','$profile',$speaker_type,'$image_name', '$status', NOW())") or 
						die(mysqli_error($con));
						
						echo 'success';
					

			    	
			    }catch(Exception $e)
			    {

			    }
			} else 
			{
				echo 'unknown_file_type';
			}
		
	}

	
	else if($text == "compare_time"){
		$start_time=strtotime($_POST['start_time']);
		$end_time=strtotime($_POST['end_time']);

		// echo $start_time." ". "<br>";
		// echo $end_time;
		if($end_time <= $start_time){
			echo 'error';
		}
	}
	//processing request for creating an event
	else if($text == "create_event")
	{
		$start_time=strtotime($_POST['start_time']);
		$end_time=strtotime($_POST['end_time']);

		/*checking if end_time is greater than the start time and also if 
		ensuring that there should be 1hr interval between the start and end_time */
		if($end_time <= $start_time || $end_time < $start_time + 60*60){
			echo 'time-error';
		}

		else{

		$salt_id = Hash::unique();
		$user_id = escape($_POST['user_id']);
		$event_name=escape($_POST['event_name']);
		$venue_id=escape($_POST['venue_id']);
		$event_type=escape($_POST['event_type']);
		$event_description=escape($_POST['event_description']);
		$attendee_no=escape($_POST['attendee_no']);
		$start_time=escape($_POST['start_time']);
		$end_time=escape($_POST['end_time']);
		$start_date=escape($_POST['start_date']);
		$end_date=escape($_POST['end_date']);		
		// $date_array=array();
		// $date_array = explode(',', $start_date);
		// $event_date=base64_encode(serialize($date_array));
		$status=0;
		$image = $_FILES['file']['name'];

			$target_dir = "../images/event_images/";
			$target_file = basename($_FILES["file"]["name"]);
			$newfilename = "";
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$extensions_arr = array("png","jpg","jpeg","JPEG","JPG");
			if( in_array($imageFileType,$extensions_arr) ){
				$checker = "1";
				$image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
			    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
			    $newfilename= $salt_id.'.'.$imageFileType;
			    $upload = $target_dir .$newfilename;
			    move_uploaded_file($_FILES['file']['tmp_name'],$upload);
			    try
			    {
						mysqli_query($con, "INSERT INTO all_events 
						(event_id, user_id, event_type, event_name, event_description, id_venue, no_of_attendees,
						start_time, end_time, start_date, event_date,  image_path, date_submitted) 
						VALUES ('$salt_id', $user_id, $event_type,'$event_name','$event_description','$venue_id',
						$attendee_no, '$start_time','$end_time','$start_date', '$end_date', '$newfilename', NOW())") or 
						die(mysqli_error($con));
						
						echo 'success';

				}
				
				catch(Exception $e)
			    {
					echo $e;
			    }
			} 
			
			else 
			{
				echo 'unknown file type';
			}

		}
		
		
	}


	//checking for available dates
	else if($text=="available_dates")
	{
		$venue_id= $_POST['venue_id'];
		$check=mysqli_query($con, "SELECT event_date AS Status FROM all_events WHERE id_venue='$venue_id'");
				$new_data=array();
				while($checkcount=mysqli_fetch_assoc($check)){
					$new_data[] = $checkcount;
				
				}

					echo json_encode($new_data);
				
	}

	//change password
	else if($text=="change_password")
	{
		$user_id=escape($_POST['user_id']);
		$new_password=escape($_POST['new_password']);
		$confirm_password=escape($_POST['confirm_password']);

		if($new_password !== $confirm_password){
			echo 'pwd-error';
		}
		else{

			$hashed_password=password_hash($confirm_password, PASSWORD_DEFAULT);

			$update=mysqli_query($con, "UPDATE users SET password='$hashed_password' WHERE id =$user_id");
			if($update){
				echo 'success';
			}
		}
	
				
	}


	else if($text == "process_free_ticket")
	{
		
		$salt_id = Hash::unique();
		$mobile_no=$_POST['mobile_number'];
		$event_id=$_POST['event_id'];

		// echo $event_id;
		// die();
		
		$event_name=$_POST['event_name'];
		
		$full_name=$_POST['full_name'];
		$email=$_POST['user_email'];

		$uuid = mt_rand(100000, 999999);
		$ticket_id= uniqid($uuid); 

		$text = $ticket_id; 
		
		// $path variable store the location where to  
		// store image and $file creates directory name 
		// of the QR code file by using 'uniqid' 
		// uniqid creates unique id based on microtime

		$path = '../images/qr_codes/'; 
		
		$image_name = $path.uniqid().".png"; 

		
		
		// $ecc stores error correction capability('L') 
		$ecc = 'L'; 
		$pixel_Size = 10; 
		$frame_Size = 10; 
		
		// Generates QR Code and Stores it in directory given 
		QRcode::png($text, $image_name, $ecc, $pixel_Size, $frame_Size); 

		try
		{
				$check=mysqli_query($con, "SELECT * FROM attendees WHERE attendee_email='$email' AND event_id='$event_id'");
				$checkcount=mysqli_num_rows($check);
				if($checkcount > 0){
					echo 'already';
					exit();
				}
				else{
					mysqli_query($con, "INSERT INTO attendees
				(event_id, ticket_id, attendee_fullname, attendee_email,
				 attendee_mobile,image_path, date_registered)
				VALUES ('$event_id', '$ticket_id','$full_name','$email',$mobile_no, 
				'$image_name', NOW())") or 
				die(mysqli_error($con));

				$message_content="You have successfully registered to attend"." ". $event_name. ",".
				"below is your ticket"." "." "."Ticket ID:"."$ticket_id";
		// Create the Transport		
		$transport = (new Swift_SmtpTransport('mail.adaptivebibo.com', 587))
		->setUsername('test@adaptivebibo.com')
		->setPassword('ckDbB2UDmXPD')
		;

		// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);

		// Create a message
		$message = (new Swift_Message())
		->setSubject('Event Registeration Ticket')
  		->setFrom(['iquarshie@adaptivebibo.com' => 'EventHUB'])
  		->setTo([$email => 'A name'])
  		->setBody($message_content)
		->attach(Swift_Attachment::fromPath($image_name))
		
		;
  

// Send the message
		$result = $mailer->send($message);
		//var_dump($result);	
		echo 'success';

				}
				
		}
		
		catch(Exception $e)
		{
			echo $e;
		}

	
		
	exit();	
	}

	//message speaker
	else if($text == "message_speaker")
	{
		
		$salt_id = Hash::unique();
		$mobile_no=$_POST['mobile_number'];
		$event_id=$_POST['event_id'];
		
		$event_name=$_POST['event_name'];
		
		$full_name=$_POST['full_name'];
		$email=$_POST['user_email'];

		$uuid = mt_rand(100000, 999999);
		$ticket_id= uniqid($uuid); 

		$text = $ticket_id; 
		
		// $path variable store the location where to  
		// store image and $file creates directory name 
		// of the QR code file by using 'uniqid' 
		// uniqid creates unique id based on microtime

		$path = '../images/qr_codes/'; 
		
		$image_name = $path.uniqid().".png"; 

		
		
		// $ecc stores error correction capability('L') 
		$ecc = 'L'; 
		$pixel_Size = 10; 
		$frame_Size = 10; 
		
		// Generates QR Code and Stores it in directory given 
		QRcode::png($text, $image_name, $ecc, $pixel_Size, $frame_Size); 

		try
		{

				$check=mysqli_query($con, "SELECT * FROM attendees WHERE attendee_email='$email' AND event_id='$event_id'");
				$checkcount=mysqli_num_rows($check);
				if($checkcount > 0){
					echo 'already';
					exit();
				}
				else{
					mysqli_query($con, "INSERT INTO attendees
				(event_id, ticket_id, attendee_fullname, attendee_email,
				 attendee_mobile,image_path, date_registered)
				VALUES ('$event_id', '$ticket_id','$full_name','$email',$mobile_no, 
				'$image_name', NOW())") or 
				die(mysqli_error($con));

				$message_content="You have successfully registered to attend"." ". $event_name. ",".
		"below is your ticket";
		// Create the Transport		
		$transport = (new Swift_SmtpTransport('mail.adaptivebibo.com', 587))
		->setUsername('test@adaptivebibo.com')
		->setPassword('ckDbB2UDmXPD')
		;

		// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);

		// Create a message
		$message = (new Swift_Message())
		->setSubject('Event Registeration Ticket')
  		->setFrom(['iquarshie@adaptivebibo.com' => 'EventHUB'])
  		->setTo([$email => 'A name'])
  		->setBody($message_content)
		->attach(Swift_Attachment::fromPath($image_name))
		
		;
  

// Send the message
		$result = $mailer->send($message);
		//var_dump($result);	
		echo 'success';
				}
				
		}
		
		catch(Exception $e)
		{
			echo $e;
		}

		
	exit();	
	}


	else if($text == "add_ticket")
	{
		$salt_id = Hash::unique();
		$user_id = escape($_POST['user_id']);

		$event_id=escape($_POST['event_id']);
		$ticket_name=escape($_POST['ticket_name']);
		$ticket_price=escape($_POST['ticket_price']);
		
			try
			    {
			    	
				mysqli_query($con, "INSERT INTO event_tickets (ticket_id, event_id, user_id, ticket_name, ticket_price) 
				VALUES ('$salt_id', '$event_id', '$user_id','$ticket_name',$ticket_price)") or 
				die(mysqli_error($con));
						
				echo 'success';
				exit();
				
				}
				catch(Exception $e)
			    {
					echo 'error';
					exit();
			    }
		
		
	}


	else if($text == "get_price")
	{
		$ticket_id = escape($_POST['ticket_id']);
		$ticket_no =escape($_POST['ticket_no']);
		$sql=mysqli_query($con,"SELECT ticket_price FROM event_tickets
		WHERE ticket_id='$ticket_id'");
		$row=mysqli_fetch_assoc($sql);
		$ticket_price=$row['ticket_price'];
		
		$result= $ticket_no * $ticket_price;
		echo $result;
		exit();

	}

	else if($text == "ticket_id")
	{	
		$hash=hash::unique();
		$ticket_id = escape($_POST['ticket_id']);
		$sql=mysqli_query($con,"SELECT * FROM all_events 
		INNER JOIN event_tickets ON all_events.event_id = event_tickets.event_id 
		WHERE event_tickets.ticket_id='$ticket_id'");
		$row=mysqli_fetch_assoc($sql);
		$ticket_id=$row['ticket_id'];
		$ticket_price=$row['ticket_price'];
		$ticket_name=$row['ticket_name'];
		
		$event_name=$row['event_name'];
		
		
		$display ='';
		$display.= '

		<div class="modal-header">
		<img src="https://payments2.ipaygh.com/app/webroot/img/LOGO-MER02820.png" class="mx-auto d-block logo">
	</div>
	<form action="https://manage.ipaygh.com/gateway/checkout" id="ipay_checkout" method="post" name="ipay_checkout" target="_blank">
		<div class="modal-body">
			<legend class="text-center mt-1">Make Payment</legend>
			<input name="merchant_key" type="hidden" value="tk_3f984306-488d-11e9-9a0b-f23c9170642f">
			<input id="merchant_code" type="hidden" value="TST000000002579">
			<input name="source" type="hidden" value="WIDGET">
			<input name="success_url" type="hidden" value="http://localhost/eventhub">
			<input name="cancelled_url" type="hidden" value="http://localhost/eventhub">
			<input id="invoice_id" name="invoice_id" type="hidden" value="'.$hash.'">
			<div class="row">
				<div class="col-lg">
					<div class="form-group">
						<label class="float-left">Event Name</label>
						<input type="hidden" class="form-control" id="ticket_id" name="ticket_id" value="'.$ticket_id.'" disabled>
						<input type="text" class="form-control" name="event_name" value="'.$event_name.'" disabled>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg">
					<div class="form-group input-group">
						<input type="text" title="Name" name="extra_name" id="name" class="form-control" placeholder="First & Last Name">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg">
					<div class="form-group">
						<label  class="float-left">No of Tickets</label>
						<select name="ticket_no" id="ticket_no" class="form-control">
							<option value="1" selected >1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg">
					<div class="form-group input-group">
						<input type="tel" title="Mobile Number" name="extra_mobile" id="number" class="form-control" maxlength="10" placeholder="Contact Number">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg">
					<div class="form-group input-group">
						<input type="email" name="email" id="extra_email" class="form-control" placeholder="Email">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg">
					<div class="form-group input-group">
						<input type="text" name="total" class="form-control" id="ticket_price" value="'.$ticket_price.'" placeholder="Amount(GH₵)" readonly>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg">
					<div class="form-group input-group">
						<input class="form-control" type="text" name="description" id="description" placeholder="Description of Payment">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg">
					<button type="submit" class="btn btn-primary ipay-btn btn-block" style="padding: 8px 11px;"><strong>Pay</strong></button>
				</div>
			</div>
			<div class="row">
				<div class="col-lg text-center mt-2">
					<a href="" data-dismiss="modal" id="close">Cancel</a>
				</div>
			</div>
		</div>
		<div class="modal-footer justify-content-center ">
			<div class="row">
				<div class="col-lg">
					<img src="https://payments.ipaygh.com/app/webroot/img/iPay_payments.png" style="width: 100%;" class="img-fluid mr-auto" alt="Powered by iPay">
				</div>
			</div>
		</div>
	</form>
        
		';

		echo $display;
		exit();
		
		
	}

	else if($text == "free_ticket_id")
	{
		
		$event_id = escape($_POST['event_id']);
		
		$sql=mysqli_query($con,"SELECT * FROM all_events
		WHERE event_id='$event_id'");
		$row=mysqli_fetch_assoc($sql);
		$id=$row['event_id'];
		$event_name=$row['event_name'];
		
		$display ='';
		$display.= '
            <div class="modal-header">
              <h4 class="modal-title">Register Ticket</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
			  <form method="POST" id="process_free_ticket">
			  <input type="hidden" class="form-control" name="event_id" value="'.$id.'" >
				<div class="form-group">
				<label style="text-align:left;">Event Name</label>
				<input type="text" class="form-control" value="'.$event_name.'" disabled>
                <input type="hidden" class="form-control" name="event_name" value="'.$event_name.'" disable>
				</div>
				<div class="form-group">
				<label>Full  Name</label>
                  <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                </div>
				<div class="form-group">
				<label>Email</label>
                  <input type="email" class="form-control" name="user_email" placeholder="Your Email" required>
                </div>
				<div class="form-group">
				<label>Mobile No</label>
                  <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number(+233552690110)" required>
                </div>
                <div class="text-center">
                  <button type="submit" id="f_ticket" class="btn">Register</button>
                </div>
              </form>
			</div>
			
			<style>
			form .form-group label{
			
			}
			<style>
        
		';

		echo $display;
		exit();
		
		
	}


	else if($text == "book_speaker_id")
	{
		
		$speaker_id = escape($_POST['speaker_id']);
		
		$sql=mysqli_query($con,"SELECT * FROM speakers
		WHERE speaker_id='$speaker_id'");
		$row=mysqli_fetch_assoc($sql);
		$id=$row['speaker_id'];
		$speaker_name=$row['full_name'];
		
		$display ='';
		$display.= '
            <div class="modal-header">
              <h4 class="modal-title">Book Speaker</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
			  <form method="POST" id="message_speaker">
			  <input type="hidden" class="form-control" name="event_id" value="'.$id.'" >
				<div class="form-group">
				<label>Full Name</label>
				<input type="text" class="form-control" value="'.$speaker_name.'" disabled>
                <input type="hidden" class="form-control" name="event_name" value="'.$speaker_name.'" disable>
				</div>
				<div class="form-group">
				<label>Email</label>
                  <input type="email" class="form-control" name="user_email" placeholder="Your Email" required>
                </div>
				<div class="form-group">
				<label>Message</label>
				<textarea class="form-control" name="message" rows="3"></textarea>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
        
		';

		echo $display;
		exit();
		
		
	}
	
	
	

	else if($text == "speak_id")
	{
		$output='';

		$event_id = escape($_POST['event_id']);
		$select = mysqli_query($con, "SELECT * FROM all_Events WHERE event_id= '$event_id'");
		$row=mysqli_fetch_assoc($select);
		$event_name=$row['event_name'];
		$start_date=$row['start_date'];
		require_once "../speechapi/voicerss_tts.php";

		$tts = new VoiceRSS;
		$voice = $tts->speech([
    	'key' => '2fc6916c25e14252ac897027d0c4aabd',
    	'hl' => 'en-us',
    	'src' => $event_name.''.$start_date,
    	'r' => '0',
    	'c' => 'mp3',
    	'f' => '44khz_16bit_stereo',
    	'ssml' => 'false',
    	'b64' => 'true'
		]);

		$output.='
		<audio src="' . $voice['response'] . '" autoplay="autoplay"></audio>
		';
		
		echo $output;
		exit();
		
	}
	
	
	

?>

