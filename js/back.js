$(document).ready(function(){
	
		//enabling camera for scanning ticket
		$("#start_scan").click(function(){
			let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {

		var event_id=$(".event_id").attr("id");
		var qr_code=content;

		$.ajax({
			url: "ajax/one.php?text=verify_qrcode",
			method:"POST",
			data:{
				event_id:event_id,
				qr_code:qr_code
        	},
			success:function(data){

				if(data.match('success')){
					Swal.fire({
						icon: 'success',
						title: 'Ticket Verified',
						showConfirmButton: false,
						timer: 2000,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });
				}
				else if (data.match('invalid')){
					Swal.fire({
						icon: 'error',
						title: 'Invalid Verified',
						showConfirmButton: false,
						timer: 2000,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });
				}
				else if(data.match('already')){

					Swal.fire({
						
						icon: 'error',
						title: 'The Ticket Has Already Been Used',
						showConfirmButton: false,
						timer: 2000,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });

				}
				
			}

		});
        
        
	  });
	  
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });

		})
	
	//ck editor
	ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
		} );
		
		//image preview
		$(document).on('submit', '#add_new_ticket', function(event){
			event.preventDefault();
			
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
					Swal.fire({
						icon: 'success',
						title: 'Ticket Added',
						showConfirmButton: false,
						timer: 2000,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });

				  location.reload();
				}
			  }
			});
		  });


		  //image preview
		$(document).on('submit', '#change_password', function(event){
			event.preventDefault();
			
			$.ajax({
			  url:"ajax/one.php?text=change_password",
			  method:'POST',
			  data:new FormData(this),
			  contentType:false,
			  processData:false,
			  success:function(data)
			  {
				
				if(data.match('success'))
				{
					Swal.fire({
						icon: 'success',
						title: 'Changed Password Succesffully',
						showConfirmButton: false,
						timer: 3500,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });

				  location.reload();
				}

				else if(data.match('pwd-error')){
					Swal.fire({
						icon: 'error',
						title: 'Password Mismatch, try again',
						showConfirmButton: false,
						timer: 2000,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });
				}
			  }
			});
		  });

		  $('#mytable').DataTable({
			destroy: true,
			paging: true,
			lengthChange: false,
			searching: true,
			ordering: true,
			info: true,
			stateSave: true,
			autoWidth: false
			
	
		});

	
		  $("#approve_event").click(function(){
			  var event_id=$("#event_id").val();
			  
			  $.ajax({
				url:"ajax/one.php?text=approve-event",
				method:'POST',
				data:{event_id:event_id},
				success:function(data)
				{
					if(data.match('success'))
					{
						Swal.fire({
							icon: 'success',
							title: 'Event Approved',
							showConfirmButton: false,
							timer: 1500,
							showClass: {
								popup: 'animate__animated animate__fadeInDown'
							  }
						  });

						window.location.href="admin-page.php?event_mgm";
					}else
					{
						
					}
				}
			});


		  })

		  $("#decline_event").click(function(){
			var event_id=$("#event_id").val();

			$.ajax({
			url:"ajax/one.php?text=decline-event",
			method:'POST',
			data:{event_id:event_id},

			success:function(data)
			{
				if(data.match('success'))
				{
					Swal.fire({
						icon: 'success',
						title: 'Event Declined',
						showConfirmButton: false,
						timer: 1500,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });
					window.location.href="admin-page.php?event_mgm'";
				}
				else
				{
					
				}
			}
		});
		})


	$(document).on('submit', '#create-event', function(event){
	event.preventDefault();

	$.ajax({
		url:"ajax/one.php?text=create_event",
		method:'POST',
		data:new FormData(this),
		contentType:false,
		processData:false,
		success:function(data)
		{
			//alert(data);				
			if(data.match('success')){

				Swal.fire({
					icon: 'success',
					title: 'Ticket Added',
					showConfirmButton: false,
					timer: 1500
				  });

				window.location.href="dashboard.php?my_events";
			}

			else if(data.match('time-error')){
				Swal.fire({
					icon: 'error',
					title: 'Interval between Start and End Time should be at least an hour',
					showConfirmButton: false,
					timer: 2500,
					showClass: {
						popup: 'animate__animated animate__fadeInDown'
					  }
				  });
			}
			else{

				Swal.fire({
					icon: 'error',
					title: 'Unsupported file format',
					showConfirmButton: false,
					timer: 1500
				  });
			}
		
		}
	});
});


$("#venue").change(function(){
	var venue_id=this.selectedOptions[0].value;

	$.ajax({
		url:"ajax/one.php?text=available_dates",
		method:'POST',
		data:{venue_id:venue_id},
		success:function(data)
		{	
			
			//alert(JSON.stringify(data));
			var listid= JSON.parse(data);

			var status=[];

      for(var i in listid){
		status.push(listid[i].Status);
		
	  }
	  //alert(JSON.stringify(status));

				$("#start_date").flatpickr({
					mode: "multiple",
					weekNumbers: true,
					altInput: true,
					altFormat: "F j, Y",
					dateFormat: "Y-m-d",
					minDate: "today",
					disable: status
				});

				$("#end_date").flatpickr({
					weekNumbers: true,
					altInput: true,
					minDate: "today",
					altFormat: "F j, Y",
					dateFormat: "Y-m-d",
					disable: status,
				});
			
		}
	});
	
})

$( '#start_time' ).flatpickr({
  noCalendar: true,
enableTime: true,
dateFormat: 'h:i K'


  });



$("#start_time").change(function(){

	var start_time=$("#start_time").val();

	$( '#end_time' ).flatpickr({
		noCalendar: true,
	  enableTime: true,
	  dateFormat: 'h:i K',
	  defaultDate: start_time,
	  minTime: start_time
  
  });

	
});



$("#end_time").change(function(){

	var start_time=$("#start_time").val();

	if(start_time == ""){
		alert("You have not selected the start time");
	}
	else{
		var end_time=$(this).val();
		$.ajax({
		url:"ajax/one.php?text=compare_time",
		method:'POST',
		data:{start_time:start_time,end_time:end_time },
		success:function(data)
		{
			//lert(data);
			if(data.match('error'))
			{
				//alert('You cannot select this time');
				$( '#end_time' ).flatpickr({
				  noCalendar: true,
				  enableTime: true,
				  dateFormat: 'h:i K',
				  defaultDate: start_time,
				  minTime: start_time
			  
			  });
			}
		}
	});
	}

	
	
});



	$(document).on('submit', '#add_ticket', function(event){
		event.preventDefault();
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

					Swal.fire({
						icon: 'success',
						title: 'Ticket Added Successfully',
						showConfirmButton: false,
						timer: 1500
					  });

					location.reload();
				}
			}
		});
	});


	$(document).on('submit', '#add_speaker', function(event){
		event.preventDefault();
	
		$.ajax({
			url:"ajax/one.php?text=add_speaker",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				//alert(data);
				if(data.match('success'))
				{

					Swal.fire({
						icon: 'success',
						title: 'Speaker Added Successfully',
						showConfirmButton: false,
						timer: 1500
					  });

					location.reload();
				}
			}
		});
	});

	$(document).on('submit', '#add_venue', function(event){
		event.preventDefault();
	
		$.ajax({
			url:"ajax/one.php?text=add_venue",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				//alert(data);
				if(data.match('success'))
				{

					Swal.fire({
						icon: 'success',
						title: 'Venue Added Successfully',
						showConfirmButton: false,
						timer: 1500
					  });

					location.reload();
				}
			}
		});
	});



	$(document).on('submit', '#update_speaker', function(event){
		event.preventDefault();
		
		$.ajax({
			url:"ajax/one.php?text=update_speaker",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				//alert(data);
				if(data.match('success'))
				{
					Swal.fire({
						icon: 'success',
						title: 'Updated Successfully',
						showConfirmButton: false,
						timer: 1500
					  });
				
					location.reload();
				}
			}
		});

	});


	

	


	
	event_status();
	function event_status(){
		$.ajax({
			url: "ajax/one.php?text=event_status",
			method:"POST",
			success:function(data){
				$("#load-investment").html(data);
			}
		});
	}

	
	//approve speaker
	$(document).on('click', '.approve', function(){
		var id = $(this).attr('id');

		$.ajax({
			url: "ajax/one.php?text=approve_speaker",
			method:"POST",
			data:{id:id},
			success:function(data){
				if(data.match('success'))
				{
					Swal.fire({
						icon: 'success',
						title: 'Approved Successfully',
						showConfirmButton: false,
						timer: 1500
					  });
					window.location.reload();
				}
			}
		});
	});

		//decline speaker
	$(document).on('click', '.decline', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=decline_speaker",
			method:"POST",
			data:{id:id},
			success:function(data){
				if(data.match('success'))
				{
					Swal.fire({
						icon: 'error',
						title: 'Declined Successfully',
						showConfirmButton: false,
						timer: 1500
					  });
					window.location.reload();
				}
			}
		});
	});


	function validate(id,text)
	{
		var letters = /^[A-Za-z- ]+$/;
		if(id == '')
		{
			return "* " + text + " Must Not Be Empty";
		}else if(id.match(letters))
		{
			return 'hello';
		}else
		{
			return "* " + text + ' Must be Alphabet';
		}
	}



	function validateMobile(id,text){
		var letters = /^[0-9]+$/;
		if(id == '')
		{
			return 'hello';
		}else if(id.match(letters))
		{
			return 'hello';
		}else if(id.length == 10)
		{
			return 'hello';
		}else
		{
			return '* ' + text + ' Must Be Digit And Also Must Be Ten In Number';
		}
	}

	


	$('.cover-image').uploadPreview({
		width: '200px',
		height: '200px',
		backgroundSize: 'cover',
		fontSize: '16px',
		borderRadius: '200px',
		border: '3px solid #dedede',
		lang: 'en', //language
	}); 




			  
});