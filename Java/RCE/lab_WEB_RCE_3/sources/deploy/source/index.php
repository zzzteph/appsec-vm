<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mortgage calculation service</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">

			<span class="contact100-form-title">
				<img src="images/logo.jpg">
			</span>

			<span class="contact100-form-title">
				Mortgage calculation service
			</span>

			<?php 
			
			if (isset($_POST["name"]) && isset($_POST["email"])) {
				if(isset($_POST["timestamp"]))	$date = $_POST["timestamp"]; else $date = time();
				generatePDF($date);
			?>

				<span class="fs-20">
					<b>Sorry! </b><br/>
					Unfortunately, our email service has broken :(   <br/>
					Please send us your request by fax +1 (999) 222-333-444	 <br/>
					For convenience, we have made pdf generator  <br/>

					<a href="/pdfs/output_<?php echo $date;?>.pdf" target="_blank">
						<span class="fs-20">
							Show and download my PDF
						</span>
					</a>
				</span>

			<?php } else { ?>

				<form class="contact100-form validate-form" method="post">

					<span class="fs-20">
						Dear visitors, we are happy to calculate our mortgage terms. <br/>
						Send the approximate amount of the loan, we will calculate and send you <br/>
						the calculations on the email.<br/>
						Thank you for staying with us.
						<br/><br/><br/>
					</span>

					<div class="wrap-input100 validate-input bg1" data-validate="Please Type Your Name">
						<span class="label-input100">FULL NAME *</span>
						<input class="input100" type="text" name="name" placeholder="Enter Your Name">
					</div>

					<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Enter Your Email (e@a.x)">
						<span class="label-input100">Email *</span>
						<input class="input100" type="text" name="email" placeholder="Enter Your Email ">
					</div>

					<div class="wrap-input100 bg1 rs1-wrap-input100">
						<span class="label-input100">Phone</span>
						<input class="input100" type="text" name="phone" placeholder="Enter Number Phone">
					</div>

					<div class="wrap-input100 input100-select bg1">
						<span class="label-input100"></span>
						<div>
							<select class="js-select2" name="service">
								<option>Please chooses</option>
								<option>For myself, an individual</option>
								<option>To company, legal entity</option>
							</select>
							<div class="dropDownSelect2"></div>
						</div>
					</div>

					<div class="w-full dis-none js-show-service">
						<div class="wrap-contact100-form-radio">
							<span class="label-input100">What type of property are you interested in?</span>

							<div class="contact100-form-radio m-t-15">
								<input class="input-radio100" id="radio1" type="radio" name="type-product" value="Residential" checked="checked">
								<label class="label-radio100" for="radio1">
									Residential Properties
								</label>
							</div>

							<div class="contact100-form-radio">
								<input class="input-radio100" id="radio2" type="radio" name="type-product" value="Commercial">
								<label class="label-radio100" for="radio2">
									Commercial real estate
								</label>
							</div>

							<div class="contact100-form-radio">
								<input class="input-radio100" id="radio3" type="radio" name="type-product" value="Warehouses">
								<label class="label-radio100" for="radio3">
									Warehouses
								</label>
							</div>
						</div>

						<div class="wrap-contact100-form-range">
							<span class="label-input100">Budget of borrowed funds *</span>

							<div class="contact100-form-range-value">
								$<span id="value-lower">610</span> - $<span id="value-upper">980</span>
								<input type="text" name="from-value">
								<input type="text" name="to-value">
							</div>

							<div class="contact100-form-range-bar">
								<div id="filter-bar"></div>
							</div>
						</div>
					</div>

					<div class="wrap-input100 validate-input bg0 rs1-alert-validate" data-validate = "Please Type Your Message">
						<input type="hidden" name="timestamp" value="<?php echo time(); ?>" />
						<span class="label-input100">Message *</span>
						<textarea class="input100" name="message" placeholder="Your message here..."></textarea>
					</div>

					<div class="container-contact100-form-btn">
						<button class="contact100-form-btn">
							<span>
								Submit
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
					</div>
				</form>

			<?php } ?>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function(){
				$(this).on('select2:close', function (e){
					if($(this).val() == "Please chooses") {
						$('.js-show-service').slideUp();
					}
					else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<script src="vendor/noui/nouislider.min.js"></script>
	<script>
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 20000, 80000 ],
	        connect: true,
	        range: {
	            'min': 10000,
	            'max': 200000
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]);
	        $('.contact100-form-range-value input[name="from-value"]').val($('#value-lower').html());
	        $('.contact100-form-range-value input[name="to-value"]').val($('#value-upper').html());
	    });
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>


</body>
</html>


<?php

function generatePDF($date){



	$body = '<!DOCTYPE html>
			<html lang="en">
				<head>
					<title>Mortgage calculation service</title>
					<meta http-equiv="content-type" content="text/html; charset=UTF-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
			
					<style type="text/css" media="all">
						html {
							margin:0;
							zoom: 1; 
						}
					</style>
				</head>
			
				<body>
				<div style="margin: 0 1cm 0 1cm; font-size: 0.65em">
					<h1>Mortgage calculation service</h1>

					<p>Thank you for your request</p>
					<p>Please send us your request by fax +1 (999) 222-333-444	</p>

					<br /><br />
					<p>Name: '.$_POST['name'].'</p>
					<p>email: '.$_POST['email'].'</p>
					<p>phone: '.$_POST['phone'].'</p>
					<p>service: '.$_POST['service'].'</p>
					<p>type-product: '.$_POST['type-product'].'</p>
					<p>from-value: '.$_POST['from-value'].'</p>
					<p>to-value: '.$_POST['to-value'].'</p>
					<p>timestamp: '.$_POST['timestamp'].'</p>
					<p>message: '.$_POST['message'].'</p>

				</div>
			</body>
			</html>';

	// Generate HTML file
	$fp = fopen("htmls/latest.html", "w");
	fwrite($fp, $body);
	fclose($fp);

	// Generate PDF file
    $command =  __DIR__ . "/phantomjs " . __DIR__ . "/pdfgen.js " . __DIR__ . "/htmls/latest.html " . __DIR__ . "/pdfs/output_$date.pdf";
	shell_exec($command);
}
