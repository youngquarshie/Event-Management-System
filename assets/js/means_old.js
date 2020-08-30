$(document).ready(function(){


	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	var readURL = function(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.upload-button').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}


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

	//ck editor
	ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
		} );
		
		//image preview
		$('.profile-pic').uploadPreview({
            width: '200px',
            height: '200px',
            backgroundSize: 'cover',
            fontSize: '16px',
            borderRadius: '200px',
            border: '3px solid #dedede',
            lang: 'en', //language
        });
	

	
	//when the login button is clicked
	$(document).on('submit', '#loggedin', function(event){
		event.preventDefault();
			//alert("hi");
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
					window.location = "./home.php";
				}
				
				else if(data.match('admin'))
				{
					window.location = "./admin-page.php";
				}else
				{
					$("#elogin").show();
				}
			}
		});
	});


	
	$(document).on('submit', '#save-client', function(event){
		event.preventDefault();
		alert();
		$.ajax({
			url:"ajax/one.php?text=save-client",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				if(data.match('success'))
				{
					sweetAlert("", "<b style='color:green;'> Client Added Successfully !!</b>", "success");
					$("#internship").modal('hide');
					load_company($("#dklsjfsdlsjfssdjf").val());
				}else
				{
					
				}
			}
		});
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
   
   //playing the audio

   $(".speak").click(function(){
	  var event_id=$(this).attr("id");
	  alert(event_id);

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

	

	setTimeout(function(){
		$('body').addClass('loaded');
	}, 1000);

	$(".file-upload").on('change', function(){
		readURL(this);
	});

	load_company($("#company").val());
	function load_company(id)
	{
		$.ajax({
			url:"ajax/one.php?text=load-company",
			method:'POST',
			data:{
                salt:id
            },
			success:function(data)
			{
				$("#load-company").html(data);
			}
		});
	}

	load_investor($("#choose").val());
	function load_investor(id)
	{
		$.ajax({
			url:"ajax/one.php?text=load-investor",
			method:'POST',
			data:{
                salt:id
            },
			success:function(data)
			{
				$("#load-investor").html(data);
			}
		});
	}

	load_jobber();
	function load_jobber()
	{
		$.ajax({
			url:"ajax/one.php?text=load-jobber",
			method:'POST',
			success:function(data)
			{
				$("#load-jobber").html(data);
			}
		});
	}



	$(".upload-button").on('click', function() {
		$(".file-upload").click();
	});

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
				alert(data);
			}
		});
	});


	$(document).on('submit', '#applyintern', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=apply-intern",
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

	$(document).on('submit', '#applyent', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=apply-entreprenuer",
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

	//internship report uploading
	$(document).on('submit', '#intern-report-upload', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=intern-report-upload",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				if(data.match('success'))
				{
					sweetAlert("", "<b style='color:green;'>Report Uploaded Successfully !!</b>", "success");
					load_company($("#dklsjfsdlsjfssdjf").val());
				}
			}
		});
	});

	$(document).on('submit', '#jobber-report-upload', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=jobber-report-upload",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				if(data.match('success'))
				{
					sweetAlert("", "<b style='color:green;'>Report Uploaded Successfully !!</b>", "success");
					load_jobber();
				}
			}
		});
	});

	$(document).on('submit', '#apply-jobber', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=apply-jobber",
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

	$(document).on('submit', '#create-event', function(event){
		event.preventDefault();
		alert();
		$.ajax({
			url:"ajax/one.php?text=apply-jobber",
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

	$(document).on('submit', '#apply-investor', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=apply-investor",
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

	$(document).on('submit', '#entreprenuer', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=entreprenuer",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{

				window.location.replace("thanks.html");

			}
		});
	});

	$(document).on('click', '.task', function(){
		var id = $("#task").val();
		$.ajax({
			url: "ajax/one.php?text=ksdlfjldvniwyorfdskfklsdflkvnwiyoiruef&mdfdmfdf="+id,
			method:"POST",
			success:function(data){
				$("#task-form").html(data);
				$("#new-task").modal("show");
			}
		});
	});

	$(document).on('submit', '#save-task', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=ndskfiwufodlfmdsfkwehfif",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	if(data.match('success'))
		    	{
		    		sweetAlert("", "<b style='color:black;'>Task Added Successfully!!</b>", "success");
		    	}
		    }
		});
	});

	$(document).on('click', '.jtask', function(){
		var id = $("#assign").val();
		$.ajax({
			url: "ajax/one.php?text=kdlnvlsdeuyhhdfbbeg&mdfdmfdf="+id,
			method:"POST",
			success:function(data){
				$("#jobber-new").html(data);
				$("#jobber-task").modal("show");
			}
		});
	});

	$(document).on('submit', '#save-assign', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=yoeruowemvmdmdnsfne",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	if(data.match('success'))
		    	{
		    		sweetAlert("", "<b style='color:black;'>Assignment Added Successfully!!</b>", "success");
		    	}
		    }
		});
	});

	load_task();
    function load_task()  
  	{  
      	$.ajax({  
          	url:"ajax/one.php?text=sjsldjflkdjvwueyovsdjhfk",  
          	method:"POST",  
          	success:function(data){  
            	$('#load-task').html(data);  
          	}  
      	})  
  	}

  	load_intern();
    function load_intern()  
  	{  
      	$.ajax({  
          	url:"ajax/one.php?text=load-intern",  
          	method:"POST",  
          	success:function(data){  
            	$('#load-intern').html(data);  
          	}  
      	})  
  	}

  	load_jobbered();
    function load_jobbered()  
  	{  
      	$.ajax({  
          	url:"ajax/one.php?text=load-jobbered",  
          	method:"POST",  
          	success:function(data){  
            	$('#load-assignment').html(data);  
          	}  
      	})  
  	}

	load_record();
	function load_record()  
	{  
		$.ajax({  
			url:"ajax/one.php?text=load_data",  
			method:"POST",  
			success:function(data){  
				$('#articles').html(data);  
			}  
		})  
	}

	// $(document).on('submit', '#save_info', function(event){
	// 	event.preventDefault();
	// 	var a = "0";
	// 	var b = "0";
	// 	var c = "0";
	// 	var d = "0";

	// 	var first = $("#first").val();
	// 	if(validate(first,"Firstname") == "hello")
	// 	{
	// 		a = "1";
	// 	}else
	// 	{
	// 		$("#ferror").text(validate(first,"Firstname"));
	// 		a = "0";
	// 	}

	// 	var surn = $("#surn").val();
	// 	if(validate(surn,"Surname") == "hello")
	// 	{
	// 		$("#serror").text('');
	// 		b = "1";
	// 	}else
	// 	{
	// 		$("#serror").text(validate(surn,"Surname"));
	// 		b = "0";
	// 	}

	// 	var pass = $("#passed").val();
	// 	var unpass = $("#unpass").val();

	// 	if(pass.match(unpass))
	// 	{
	// 		$("#perror").text('');
	// 		c = "1";
	// 	}else
	// 	{
	// 		$("#perror").text('Password Mismatch');
	// 		c = "0";
	// 	}

	// 	var mobile = $("#mobile").val();
	// 	if(validateMobile(mobile,"Mobile Number") == "hello")
	// 	{
	// 		$("#mserror").text('');
	// 		d = "1";
	// 	}else
	// 	{
	// 		$("#mserror").text(validate(first,"Mobile Number"));
	// 		d = "0";
	// 	}

	// 	if(a.match("1") && b.match("1") && c.match("1") && d.match("1"))
	// 	{
	// 		$.ajax({
	// 			url:"ajax/one.php?text=save_info",
	// 			method:'POST',
	// 			data:new FormData(this),
	// 			contentType:false,
	// 			processData:false,
	// 			success:function(data)
	// 			{
	// 				if(data.match('success'))
	// 				{
	// 					window.location = "?u";
	// 				}
	// 			}
	// 		});
	// 	}
	// });

	$(document).on('submit', '#posted', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=posted",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	if(data.match('success'))
		    	{
		    		alert(data);
		    		$('#posted')[0].reset();
		    		Ckupdate();
		    	}
		    }
		});
	});

	load_investment();
	function load_investment(){
		$.ajax({
			url: "ajax/one.php?text=load-investment",
			method:"POST",
			success:function(data){
				$("#load-investment").html(data);
			}
		});
	}

	load_post();
	function load_post(){
		$.ajax({
			url: "ajax/one.php?text=nfksdkfewldkfmsdlkfwiuhvndskfjwu",
			method:"POST",
			success:function(data){
				$("#load_post").html(data);
			}
		});
	}

	$(document).on('focusout', '#first',function(){
		var first = $("#first").val();
		if(validate(first,"Firstname") == "hello")
		{
			$("#ferror").text('');
		}else
		{
			$("#ferror").text(validate(first,"Firstname"));
		}
	});

	$(document).on('focusout', '#emailed',function(){
		var first = $("#emailed").val();
		$.ajax({
			url:"ajax/one.php?text=checkedmail&email="+ first,
			method:'POST',
			success:function(data)
			{
				if(data.match('wrong'))
				{
					$("#eerror").text("* Email Already Exist");
				}else
				{
					$("#eerror").text("");
				}
			}
		});
	});

	$(document).on('focusout', '#surn',function(){
		var first = $("#surn").val();
		if(validate(first,"Surname") == "hello")
		{
			$("#serror").text('');
		}else
		{
			$("#serror").text(validate(first,"Surname"));
		}
	});

	$(document).on('click', '.toggle-password',function(){
		$(this).toggleClass("fa-eye fa-eye-slash");
		var x = document.getElementById("pass");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	});

	$(document).on('click', '.change', function(){
		var id = $(this).attr('id');
		alert(id);
	});

	$(document).on('change', '#country', function(){
		var code = $(this).val();
		if (code){
			$('#contact1').val(code);
		}

	});

	//displying team member's modal
	$(document).on('click', '.add_member', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=add_team_member",
			method:"POST",
			data:{
				salt:id
        	},
			success:function(data){
				$("#form-add-member").html(data);
				$("#add_member").modal("show");
			}
		});
	});

	//saving team member to business
	$(document).on('submit', '#save-team-member', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=save-team-member",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				if(data.match('success'))
				{
					sweetAlert("", "<b style='color:green;'> Team Member Added Successfully !!</b>", "success");
					$("#add_member").modal("hide");
				}
			}
		});
	});

	//displying team member's modal for editing
	$(document).on('click', '.edit_member', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=edit_team_member",
			method:"POST",
			data:{
				salt:id
        	},
			success:function(data){
				$("#form-edit-member").html(data);
				$("#edit_member").modal("show");
			}
		});
	});

	$(document).on('submit', '#edit-team-member', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=edit-team-member",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				if(data.match('success'))
				{
					sweetAlert("", "<b style='color:green;'> Team Member Added Successfully !!</b>", "success");
					$("#edit_member").modal("hide");
				}
			}
		});
	});

	//displying team member's modal for editing
	$(document).on('click', '.remove_member', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=remove_team_member",
			method:"POST",
			data:{
				salt:id
        	},
			success:function(data){
				$("#form-remove-member").html(data);
				$("#remove_member").modal("show");
			}
		});
	});

	$(document).on('submit', '#remove-team-member', function(event){
		event.preventDefault();
		$.ajax({
			url:"ajax/one.php?text=remove-team-member",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
				if(data.match('success'))
				{
					sweetAlert("", "<b style='color:green;'> Team Member Removed Successfully !!</b>", "success");
					$("#remove_member").modal("hide");
				}
			}
		});
	});

	//saving customize page
	$(document).on('submit', '#save_page', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=dskflskldnvweyeriueodshfuiewur38728hfdifhd",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	alert(data);
		    }
		});
	});

	//displaying dashboard items status
	$(document).on('click', '.status', function(){
		var id = $(this).attr('id');
		check_status(id);
		$("#status_modal").modal("show");
	});

	//loading dashboard items status
	function check_status(id){
		$.ajax({
			url: "ajax/one.php?text=bmklfdgjlfgrnnerlknbdndriuowpgbpfjbodfdfjgflk&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				$("#status_body").html(data);
			}
		});
	}

	//button to active the status of ibpage states
	$(document).on('click', '.customer_deactivate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkdfjkdsjfewnkdskdjfiewjkwjds&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.category', function(){
		$("#category").modal("show");
	});

	$(document).on('click', '.c_edit', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlksjfsdsfsdflkew8uondnfiuyfwodu&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				$("#gories").html(data);
				$("#categories").modal("show");
			}
		});
	});

	$(document).on('submit', '#new_category', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=dsflkfjljflwjldhf732o8723yidushfkbw38",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	load_category();
		    	alert(data);
		    	$("#category").modal("hide");
		    }
		});
	});

	$(document).on('submit', '#edit_category', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=mdskflkdjfwiioufosdsonovnsjd",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	load_category();
		    	alert(data);
		    	$("#categories").modal("hide");
		    }
		});
	});

	$(document).on('click', '.approve', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dklsvlksndofvwiuiofuwoeyovusonvoewf8yew8ruovdnoisffjoew&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				$("#load_approve").html(data);
				$("#business-modal").modal("show");
			}
		});
	});

	//loading saved categories
	load_category();
    function load_category()  
  	{  
      	$.ajax({  
          	url:"ajax/one.php?text=dsilkfjlkfjsdkfhiewyr893udovcigvwe79dsf",  
          	method:"POST",  
          	success:function(data){  
            	$('#category_table').html(data);  
          	}  
      	})  
  	}

  	$(document).on('submit', '#revert_form', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=dsklfdlkvnkew7r3292032udsiolkdnfkeh28332jdnlkfjds",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	if(data.match('success'))
		    	{
		    		$("#business-modal").modal("hide");
		    		sweetAlert("", "<b style='color:black;'>Reverted Successfully!!</b>", "success");
		    		load_business();
		    	}
		    }
		});
	});

	$(document).on('click', '.add_business', function(){
		$.ajax({
			url: "ajax/one.php?text=bmklfdfdkenvkdweuwjdnfshfewyiyskdnsnfkdnsfewdtsfew",
			method:"POST",
			success:function(data){
				$("#add-business-form").html(data);
				$("#add-business-modal").modal("show");
			}
		});
	});

	$(document).on('submit', '#submit-form-business', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=submit-form-business",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	if(data.match('success'))
		    	{
		    		load_business();
		    		$("#add-business-modal").modal("hide");
		    		sweetAlert("", "<b style='color:black;'>Reverted Successfully!!</b>", "success");
		    	}
		    }
		});
	});

	$(document).on('submit', '#approve_form', function(event){
	    event.preventDefault();
	    $.ajax({
		    url:"ajax/one.php?text=dlfjslfjsdlkvlkkmsdlvmewlnvoiwewrvnsvddsk",
		    method:'POST',
		    data:new FormData(this),
		    contentType:false,
		    processData:false,
		    success:function(data)
		    {
		    	if(data.match('success'))
		    	{
		    		$("#business-modal").modal("hide");
		    		sweetAlert("", "<b style='color:black;'>Approved Successfully!!</b>", "success");
		    		load_business();
		    	}
		    }
		});
	});

  	load_business();
    function load_business()  
  	{  
      	$.ajax({  
          	url:"ajax/one.php?text=lkdsjfkldsviuwyieru3287490ofjwyf82ufjdsgfu23yrfjd",  
          	method:"POST",  
          	success:function(data){  
            	$('#business').html(data);  
          	}  
      	})  
  	}

	$(document).on('click', '.customer_activate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkdfjkdsjfewnkdskdjfiewjkwjdssdsdsdsdsd&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.intern_deactivate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkdfjkdsjfewnkdskdjfiewmmdnnsdfdfnndfdjkwjds&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.intern_activate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkdfjkdsjfewnkdskdjfiewjmmmnbnfbbbkwjdssdsdsdsdsd&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.ent_deactivate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkdfjkdsjfdjfdkjfkenkdnkdfkewnkdskdjfiewmmdnnsdfdfnndfdjkwjds&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.ent_activate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkldfkdkflewkdfjiedfjkdsjfewnkdskdjfiewjmmmnbnfbbbkwjdssdsdsdsdsd&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.jobber_deactivate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkdfjkdsjfdjfdkjfkenkdnkdfksdfsdfewnkddfsfdfsfsskdjfiewmmdnnsdfdfnndfdjkwjds&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.jobber_activate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlsdflvlkldfkdkflewkdfjiedfjkdsjfewnfdsfdkdskdjfiedfsdfswjmmmnbnfbbbkwjdssdsdsdsddsfdssd&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});
	
	$(document).on('click', '.investor_deactivate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dlksdfsdfewnkddfsfdfsfsfdjkwjds&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('click', '.investor_activate', function(){
		var id = $(this).attr('id');
		$.ajax({
			url: "ajax/one.php?text=dskdjfiedfdsddsfdssd&ddkfjdkjs="+id,
			method:"POST",
			success:function(data){
				if(data.match('success'))
				{
					check_status(id);
				}
			}
		});
	});

	$(document).on('change', '#country', function(){
		var code = $(this).val();
		if (code){
			$('#code').val(code);
		}

	});


	$(document).on('change', '#line', function(){
		var id = $(this).val();
		$.ajax({
			url:"ajax/one.php?text=industry&id="+ id,
			method:'POST',
			success:function(data)
			{
				$("#category").html(data);
			}
		});
	});

	$(document).on('focusout', '#mobile',function(){
		var first = $("#mobile").val();
		if(validateMobile(first,"Surname") == "hello")
		{
			$("#merror").text('');
		}else
		{
			$("#mserror").text(validate(first,"Mobile Number"));
		}
	});

	$(document).on('focusout', '#unpass',function(){
		var pass = $("#passed").val();
		var unpass = $("#unpass").val();

		if(pass.match(unpass))
		{
			$("#perror").text('');
		}else
		{
			$("#perror").text('Password Mismatch');
		}
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
});