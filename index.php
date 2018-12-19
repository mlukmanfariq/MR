<?php
	require "login.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8">
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<title>PT POLYTAMA PROPINDO</title>
	
		<!-- Bootstrap core CSS -->
		<link href="assets/css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<!--external css-->
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>
		<!-- Custom styles for this template -->
		<link href="assets/css/custom.css" rel="stylesheet">
		<link href="assets/css/login.css" rel="stylesheet">
		<link rel="shortcut icon" href= "assets/img/masplene.ico" />

	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top scrollclass" >
			<div id="header" class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">PT POLYTAMA PROPINDO</a>
				</div>
				<nav id="nav" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#home" >HOME</a></li>
						<li><a href="#login" >SIGN IN</a></li>
						<li><a href="#contact" >CONTACT</a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!--HOME SECTION-->
		<section id="home">
			<div class="container">
				<div class="row text-center">
					<div class="col-md-12 " >
						<div id="carousel-example" class="carousel slide" data-ride="carousel" style="padding-top:130px"><br/>
							<ol class="carousel-indicators">
								<li data-target="#carousel-example" data-slide-to="0" class="active"></li>
								<li data-target="#carousel-example" data-slide-to="1"></li>
								<li data-target="#carousel-example" data-slide-to="2"></li>
							</ol>
							<div class="carousel-inner" role="listbox">
								<div class="item active">
									<!--<img src="assets/img/login-bg2.jpg" alt="Chania">-->
									<div class="container center" >
										<div class="col-md-6 col-md-offset-3 slide-custom"><br/>
											<h4>VISION </br> To be a resilient, dynamic leader of polypropylene producer in Indonesia towards satisfied customer and stakeholder orientation.</h4>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="container center">
										<div class="col-md-6 col-md-offset-3 slide-custom">
											<h4>LOOKING FORWARD <br/>
												Polytama Propindo always consistent in production and delivers material with high quality products.Masplene® will consistently lead the market and challenge the  future polypropylene industr</h4>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="container center">
										<div class="col-md-6 col-md-offset-3 slide-custom">
											<h4>ABOUT PP<br/>
												The factory located in Balongan, Juntinyuat district, Indramayu-West Java, using one of  the best technology in the world, the Spheripol technology of Montell (now LyondellBasell), with an installed capacity of 100,000 metric tons per year. </h4>	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--END ABOUT SECTION-->
		<!-- MAIN CONTENT -->
		<section class="for-full-back color-bg-one" id="login">
			<div class="container">
				<div class="row text-center">
					<div id="sign-in" class="col-md-8 col-md-offset-2 "><br/><br/><br/>
						<h1>SIGN IN</h1>
					</div>
				</div>
			</div>
		</section>
		<section class="for-full-back color-white" id="login">
			<div id="login-page">
				<div class="container">
					<div class="position-relative">
						<div id="login-box" class="login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<form class="form-login"action="<?php $_SERVER["PHP_SELF"]?>#login" name="login" method="post">					
										<div class="login-wrap">							
											<div class="form-group input-group">
												<span class="input-group-addon"><i class="fa fa-user"></i></span>
												<input type="text" class="form-control" name="user_id" placeholder="User ID" required/>
											</div>
											<div class="form-group input-group">
												<span class="input-group-addon"><i class="fa fa-lock"></i></span>
												<input type="password" class="form-control" name="password" placeholder="Password" required/>
											</div>
											<button class="btn btn-theme btn-block" name="login" type="submit" action="login.php"><i class="fa fa-lock"></i> SIGN IN</button>
											<br>
											<div class="toolbar clearfix">
												<div>
													<a href="#" data-target="#forgot-box" class="forgot-password-link">
														<i class="ace-icon fa fa-arrow-left"></i>
														I forgot my password
													</a>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div id="forgot-box" class="forgot-box widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<form class="form-login" method="post" id="reg-form" autocomplete="off">
										<div class="login-wrap">																		
											<div class="form-group input-group">
												<span class="input-group-addon"><i class="fa fa-tag"></i></span>
												<input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" required/>
											</div>
											<div class="form-group input-group">
												<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
												<input type="text" class="form-control" id="email" name="email" placeholder="Internal Email" required/>
											</div>
											<button class="btn btn-danger btn-block reset" ><i class="fa fa-lock"></i> RESET PASSWORD</button>
											<br>
											<div class="toolbar center">
												<a href="#" data-target="#login-box" class="back-to-login-link">
													Back to login
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>
									</form>
									<div class="col-sm-6 col-sm-offset-3">
										<div id="message"></div>
									</div>
								</div><!-- /.widget-main -->
							</div><!-- /.widget-body -->
						</div><!-- /.forgot-box -->
					</div>
				</div>	
				<?php 
					if($error!=""){
						echo'
						<div class="alert2">
						  <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
						  <center>'.$error.'
						</div>';
					}
				?>
			</div>
		</section>
		<!--CONTACT SECTION-->
		<section class="for-full-back color-bg-one">
			<div class="container">
				<div class="row text-center">
					<div id="contact" class="col-md-8 col-md-offset-2">
						<h1>Contact</h1>
					</div>
					<div class="row text-center">
						<div class="col-md-8 col-md-offset-2 ">
							<h4>
								You can find us literally anywhere, just push a button and we’re there
							</h4>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="for-full-back color-white text-center" id="contact-inner">
			<div class="container">
				<div id="add">
					<h4>
						Mid Plaza 2 Lt.20, Jl. Jend. Sudirman No.10-11, Kota Jakarta Pusat<br />
						Daerah Khusus Ibukota Jakarta 10220
						<br/>
						Phone:(021) 5703883
						<br/>
						Fax : (62-21) 5704689
					</h4>
					<br/>
					<h4>
						Jl. Raya Juntinyuat Km.13 Ds. Limbangan<br />
						Indramayu Jawa Barat 45282
						<br/>
						Phone:(0234) 428002
					</h4>
				</div>
			</div>
		</section>
		<!--END CONTACT SECTION-->		
		<!--FOOTER SECTION -->
		<div class="for-full-back" id="footer">
			<center>
				© 2017 Copyright: PT POLYTAMA PROPINDO
			</center>
		</div>
		<!-- END FOOTER SECTION -->
		
		<!-- js placed at the end of the document so the pages load faster -->
		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
	
		<!--common script for all pages-->
		<!--BACKSTRETCH-->
		<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
		<script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
		<script>
			$.backstretch("assets/img/background12.jpg", {speed: 500});
		</script>
		<!-- SCRIPTS -->
		<script src="js/jquery-1.10.2.min.js"></script>
		<!-- SCROLL SCRIPTS -->
		<script src="assets/js/plugins/jquery.easing.min.js"></script>
		<!-- CUSTOM SCRIPTS -->
		<script src="assets/js/plugins/custom.js"></script>
		<script>
			$(document).ready(function() {
				var reset = $(".reset"); 
				$(reset).click(function(e){
					e.preventDefault(); // Prevent Default Submission
					var no 	= $('#nik').val();
					var em 	= $('#email').val();
					$.ajax({
						url: "reset_pass.php",
						type: "POST",
						dataType: 'html',
						data:{
							nik:no,
							email:em,
						},
						success: function(data){
							$("#message").html(data);
						}
					});
				});
			});
			$(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			
				
			$(".alert2").fadeTo(3000, 500).slideUp(500, function(){
				$(".alert2").slideUp(500);
			});
		</script>
	</body>
</html>
