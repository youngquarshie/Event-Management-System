<?php  
session_start(); 
if(isset($_SESSION['admin_sid']) || isset($_SESSION['customer_sid']))
{
	header("location:index.php");
}
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>KTU Event Hub | Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./assets/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="./assets/vendor/css-hamburgers/hamburgers.min.css">

	<link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/main.css">

	<link href="assets/img/small-icon.png" rel="icon">
  <link href="assets/img/fav-icon.png" rel="apple-touch-icon">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
				<form class="login100-form validate-form"  id="loggedin" method="POST">
					<span class="login100-form-title p-b-55">
						Login
					</span>
          
          <div class="wrap-input100 validate-input m-b-16" >
						<input class="input100" type="email" name="username" placeholder="Email" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16"  >
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
					</div>
					
					<div class="container-login100-form-btn p-t-25">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center w-full p-t-115">
						<span class="txt1">
							Haven't registed?
						</span>

						<a class="txt1 bo1 hov1" href="register.php">
							Sign up now							
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

<!--===============================================================================================-->	
	<script src="./assets/vendor/jquery/jquery-3.2.1.min.js"></script>

<!--===============================================================================================-->
	<script src="./assets/vendor/bootstrap/js/popper.js"></script>
	<script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!--===============================================================================================-->
	<script src="assets/js/front.js"></script>

	  
</body>
</html>
<?php
}
?>