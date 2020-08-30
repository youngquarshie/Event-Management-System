$(document).ready(function(){
		//removing events which has already occured
	$.ajax({
		url:"ajax/one.php?text=jk3454jh43435",
		method:'POST',
		contentType:false,
		processData:false,
		success:function(data)
		{
			//alert(data);
		}
	});

	//events occuring on the current date
	$.ajax({
		url:"ajax/one.php?text=bvdgdhjf483",
		method:'POST',
		contentType:false,
		processData:false,
		success:function(data)
		{
			//alert(data);
		}
	});
	

	//getting events and loading their specific forms
	$(document).on('change', '#event_category', function(){
		var category_id = this.selectedOptions[0].value;
		var category_text  = this.selectedOptions[0].text;
		
		$.ajax({
			url: "ajax/one.php?text=load_event_forms",
			method:"POST",
			data:{
				category_id:category_id,
				category_text:category_text
        	},
			success:function(data){
				$("#load_event_forms").html(data);
			}
		});
	});


	
	//when the login button is clicked
	$(document).on('submit', '#loggedin', function(event){
		event.preventDefault();
		

		$.ajax({
			url:"ajax/one.php?text=loggedin",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				//alert(data);
				if(data.match('cust'))
				{
					Swal.fire({
						icon: 'success',
						title: 'Logged In Successfully',
						showConfirmButton: false,
						timer: 3500,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });
					window.location = "./dashboard.php";
				}
				
				else if(data.match('admin'))
				{
					window.location = "./admin-page.php";
				}
				else if(data.match('incorrect'))
				{
					Swal.fire({
						icon: 'error',
						title: 'Wrong username or password, try again',
						showConfirmButton: false,
						timer: 3500,
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						  }
					  });
				}
			}
		});
	});


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


	$(document).on('submit', '#add_speaker', function(event){
		event.preventDefault();
		//alert();
		$.ajax({
			url:"ajax/one.php?text=add_speaker",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				alert(data);
				if(data.match('success'))
				{
					location.reload();
				}
			}
		});
	});


	//booking speaker
	$(document).on('click', '.book_speaker', function(e){
		e.preventDefault();  
		var speaker_id = $(this).attr("id");  
		//lert(event_id);
		$.ajax({  
			 url:"ajax/one.php?text=book_speaker_id",  
			 method:"post",  
			 data:{speaker_id:speaker_id},  
			 success:function(data){ 
				 //alert(data);
				  $('.modal-content').html(data);  
				  $('#speaker-modal').modal("show");  
			 }  
		});  
	});



	$(document).on('submit', '#message_speaker', function(event){
		event.preventDefault();
		
		$("#f_ticket").attr("disabled", true);
	   
			$.ajax({
				url:"ajax/one.php?text=message_speaker",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
			//alert(data);
			if(data.match('success')){
			  alert("You have successfully registered, Your ticket has been sent to your inbox");
			  location.reload();
			}
			else if(data.match('already')){
			  alert("You have already registered for this event");
			  $("#f_ticket").attr("disabled", false);
			}
			else{
			  alert("There was an error, please try again");
			  $("#f_ticket").attr("disabled", false);
			}
					
				}
			});
		});


	///disaplying buy ticket  modal
	$('.buy_ticket').click(function(e){
		e.preventDefault();  
		var event_id = $(this).attr("id");  
		//alert(ticket_id);
		$.ajax({  
			 url:"ajax/one.php?text=ticket_id",  
			 method:"post",  
			 data:{event_id:event_id},  
			 success:function(data){ 
				 //alert(data);
				  $('.modal-content').html(data);  
				  $('#buy-ticket-modal').modal("show");  
			 }  
		});  
   });

 

   $(".speak").click(function(){
	  var event_id=$(this).attr("id");
	  
  $.ajax({
	url:"ajax/one.php?text=speak_id",
	method:"post",
	data:{
		event_id:event_id
	},
	success:function(result){
		$("#play_audio").html(result);
	}
		
  })
}) 


 // Buy tickets select the ticket type on click
 $('#buy-ticket-modal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var ticketType = button.data('ticket-type');
    var modal = $(this);
    modal.find('#ticket-type').val(ticketType);
  })


 ///disaplying buy ticket  modal
 $('.buy_ticket').click(function(e){
  e.preventDefault();  
  var ticket_id = $(this).attr("id");  
  //alert(ticket_id);
  $.ajax({  
     url:"ajax/one.php?text=ticket_id",  
     method:"post",  
     data:{ticket_id:ticket_id},  
     success:function(result){ 
       //alert(result);
        $('.modal-content').html(result);  
        $('#buy-ticket-modal').modal("show");  
     }  
  });  
 });


  ///disaplying register free ticket  modal
	$('.register_ticket').click(function(e){
		e.preventDefault();  
		var event_id = $(this).attr("id");  
		//lert(event_id);
		$.ajax({  
			 url:"ajax/one.php?text=free_ticket_id",  
			 method:"post",  
			 data:{event_id:event_id},  
			 success:function(data){ 
				 //alert(data);
				  $('.modal-content').html(data);  
				  $('#register-ticket-modal').modal("show");  
			 }  
		});  
   });

   


   $(document).on('submit', '#process_free_ticket', function(event){
    event.preventDefault();
    
    $("#f_ticket").attr("disabled", true);
   
		$.ajax({
			url:"ajax/one.php?text=process_free_ticket",
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
				title: 'You have successfully registered, Your ticket has been sent to your inbox',
				showConfirmButton: false,
				timer: 3000,
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				  }
			  });

			  setTimeout(function(){
				location.reload();
			  },3000);

         
        }
        else if(data.match('already')){

			Swal.fire({
				icon: 'error',
				title: 'You have already registered for this event',
				showConfirmButton: false,
				timer: 1500,
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				  }
			  });

          $("#f_ticket").attr("disabled", false);
        }
        else{
		  //alert("There was an error, please try again");
		  Swal.fire({
			icon: 'success',
			title: 'There was an error, please try again',
			showConfirmButton: false,
			timer: 1500,
			showClass: {
				popup: 'animate__animated animate__fadeInDown'
			  }
		  });

          $("#f_ticket").attr("disabled", false);
        }
				
			}
		});
	});




 $(document).on('change',"#ticket_no", function () {
//alert();
var optionSelected = $("option:selected", this);
var ticket_no = this.value;
var ticket_id =$("#ticket_id").val();

$.ajax({  
  url:"ajax/one.php?text=get_price",  
  method:"post",  
  data:{ticket_no:ticket_no,
  ticket_id:ticket_id},  
  success:function(result){ 
    //alert(result);
    $("#ticket_price").val(result);
  }  
}); 


});


});



$(document).ready(function(){
        
	$(".toggle-password").click(function() {

	  $(this).toggleClass("zmdi-eye zmdi-eye-off");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
		input.attr("type", "text");
	  } else {
		input.attr("type", "password");
	  }
	});

	$(document).on("submit", "#save_info", function(event){
	  event.preventDefault();
	 
		$.ajax({
		  url:"ajax/one.php?text=save_info",
		  method:"POST",
		  data:new FormData(this),
		  contentType:false,
		  processData:false,
		  success:function(data)
		  {
			  //alert(data);
			$("#message").show();
			if(data.match("success"))
			{
			  //alert(data);0
			  window.location = "?login";
			}
			else{
			  //alert(data);
			  $("#message").html(data);
			}
		  }
		});
	  
	});


  })
