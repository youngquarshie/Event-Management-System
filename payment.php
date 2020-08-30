<div>
	<html class="fonts">
		<head>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
			<style type="text/css">.fonts{font-size: 12.5px;}.ipay-btn{background-color: #04448C;border-color: #04448C;border-radius: 17px !important;}.modal{width: 27% !important;}.modal-header{padding-left:48px !important;padding-right: 48px !important;border-bottom: none !important;text-align: center !important;}.modal-footer{height: 120px;padding-left:48px !important;padding-right: 48px !important;margin-bottom: -17px !important;border-top: none !important;}.modal-body{margin-bottom: -25px;padding-right: 48px !important;padding-left: 48px !important;border-bottom: none !important;margin-top: -27px;}#close:hover{text-decoration: none !important;}.logo{width: 65px;height: 65px;}</style>
		</head>
		<body>
			<div class="container">
				<div class="row">
						<div class="col-lg-3 col-md-3 col-xs-3 col-sm-5">
						<div class="input-group-prepend">
							<button type="button" class="btn btn-primary ipay-btn" data-toggle="modal" data-target="#ipayModal">Make Payment</button>
						</div>
					</div>
				</div>
				<div id="ipayModal" class="modal fade m-auto" role="dialog" data-keyboard="true" data-backdrop="true">
					<div class="modal-dialog">
						<div class="modal-content">
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
									<input id="invoice_id" name="invoice_id" type="hidden" value="">
									<div class="row">
										<div class="col-lg">
											<div class="form-group input-group">
												<input type="text" title="Name" name="extra_name" id="name" class="form-control" placeholder="First & Last Name">
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
												<input type="text" name="total" class="form-control" id="total" placeholder="Amount(GH₵)">
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
						</div>
					</div>
				</div>
			</div>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
			<script type="text/javascript">(function(){Date.prototype.today = function () { return  this.getFullYear()+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +((this.getDate() < 10)?"0":"") + this.getDate();};Date.prototype.timeNow = function () { return ((this.getHours() < 10)?"0":"") + this.getHours() +((this.getMinutes() < 10)?"0":"") + this.getMinutes() +((this.getSeconds() < 10)?"0":"") + this.getSeconds();};document.getElementById("invoice_id").value = document.getElementById("merchant_code").value+ new Date().today() + new Date().timeNow();})();</script>
		</body>
	</html>
</div>