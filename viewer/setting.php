<?php 
	include("akses.php");
	include("../db_login.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>User</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="../assets/css/bootstrap.css" />
		<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="../assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="../assets/css/chosen.min.css" />
		<link rel="stylesheet" href="../assets/css/datepicker.min.css" />
		<link rel="stylesheet" href="../assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="../assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="../ssets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="../assets/css/colorpicker.min.css" />
		<link rel="shortcut icon" href= "../assets/img/masplene.ico" />
		<link href="../assets/css/custom.css" rel="stylesheet">
		<link rel="shortcut icon" href= "../assets/img/masplene.ico" />
		<!-- text fonts -->
		<link rel="stylesheet" href="../assets/fonts/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="../assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!-- ace settings handler -->
		<script src="../assets/js/ace-extra.min.js"></script>
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small>
							<i class="fa fa-user"></i>
							User (Puchasing)
						</small>
					</a>
				</div>
				<div class="navbar-buttons navbar-header pull-left" role="navigation">
					<div id="message"></div>
				</div>
				<div class="navbar-buttons navbar-header pull-right"> 
					<ul class="nav ace-nav">
						<li class="green">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span class="user-info">
								<?php
									$nik = $_SESSION['user_pur'];
									$query = pg_query($conn, "SELECT * FROM tbl_r_general_user WHERE nik = '$nik' ");
									$result = pg_fetch_array($query);				
									$dept =  $result['department'];
									echo "<small>".$nik."</small>".$result['user_name'];
								?>
								</span>
								<img class="nav-user-photo" src="../assets/img/user.png" alt="Jason's Photo" />
								<i class="ace-icon fa fa-caret-down"></i>
							</a>
							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="setting.php">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="../logout.php">
										<i class="ace-icon fa fa-power-off"></i>Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
				<ul class="nav nav-list">
					<li class="active">
						<a href="index.php">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Home</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-th-list"></i>
							<span class="menu-text">View Report</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>
						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="view_report.php">
									<i class="menu-icon fa fa-map-marker"></i>View Summary MR
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="view_detail_report.php">
									<i class="menu-icon fa fa-list-ol"></i>View Detail Item
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active">Setting</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="row">
							<div class="col-sm-12">
								<center><h1>Change Password</h1>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								<p class="text-center">Use the form below to change your password. Your password cannot be the same as your username.</p>
								<form method="post" id="passwordForm">
									<?php
										$pass1 = $pass2 = $password1 = $valid_password21 = $valid_password2 = $valid = "";
										if (isset($_POST["save"])){
											$pass1	= pg_escape_string($_POST["password1"]);
											$pass2	= pg_escape_string($_POST["password2"]);
											if($pass1 == ''){
												$valid_password1 = FALSE;
											}else {
												$valid_password1 = TRUE;
											}
											if($pass2 == ''){
												$valid_password2 = FALSE;
											}elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$pass2)) {
												$valid_password2 = FALSE;
											}else{
												$valid_password2 = TRUE;
											}
											if($pass1 == $pass2){
												 $valid  = TRUE;
											}else{
												 $valid  = FALSE;
											}
											$password = $pass2;
											if($valid_password1 && $valid_password2 && $valid) {
												$sql = "UPDATE tbl_r_general_user SET password='$password', modified_date = current_date, modified_by = '$nik' WHERE nik= '$nik' ";
												//echo $sql;
												$update = pg_query($conn, $sql);
												if (!$update){
													die("could not query the database: <br />".pg_errormessage());
												}
												else{
													pg_free_result($update);
													pg_close($conn);
													$_SESSION['EDIT_PASS']=
													'<div class="alert alert-success" id="success-alert">
														<button type="button" class="close" data-dismiss="alert">x</button>
														<strong>you have successfully update password</strong>
													</div>';
												}
											}else{
												$_SESSION['WRONG_PASS']=
												'<div class="alert alert-danger" id="success-alert">
													<button type="button" class="close" data-dismiss="alert">x</button>
													<strong>unable to change password, please try again !!</strong>
												</div>';
											}
										}
									?>
									<input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off" required>
									<div class="row">
										<div class="col-sm-6">
											<span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 8 Characters Long<br>
											<span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Uppercase Letter
										</div>
										<div class="col-sm-6">
											<span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Lowercase Letter<br>
											<span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Number
										</div>
									</div>
									<input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off" required>
									<div class="row">
										<div class="col-sm-12">
											<span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Passwords Match
										</div>
									</div>
									<input type="submit" name="save" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Changing Password..." value="Change Password">
								</form>
							</div><!--/col-sm-6-->
						</div><!--/row-->
						<br>
						<div class="row">
							<div class="col-sm-6  col-sm-offset-3">
								<?php
									if(isset($_SESSION['EDIT_PASS'])){
										echo $_SESSION['EDIT_PASS'];
										unset($_SESSION['EDIT_PASS']);
									}
									if(isset($_SESSION['WRONG_PASS'])){
										echo $_SESSION['WRONG_PASS'];
										unset($_SESSION['WRONG_PASS']);
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">PT POLYTAMA PROPINDO </span>
							 © 2017
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>
		<script src="../assets/js/jquery.2.1.1.min.js"></script>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='../assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/js/highcharts.js"></script>
		<script src="../assets/js/exporting.js"></script>		
		<!-- ace scripts -->
		<script src="../assets/js/ace-elements.min.js"></script>
		<script src="../assets/js/ace.min.js"></script>
		<script type="text/javascript"> 
			$("#success-alert").alert();
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").slideUp(500);
				});   
			$("input[type=password]").keyup(function(){
				var ucase = new RegExp("[A-Z]+");
				var lcase = new RegExp("[a-z]+");
				var num = new RegExp("[0-9]+");
				
				if($("#password1").val().length >= 8){
					$("#8char").removeClass("glyphicon-remove");
					$("#8char").addClass("glyphicon-ok");
					$("#8char").css("color","#00A41E");
				}else{
					$("#8char").removeClass("glyphicon-ok");
					$("#8char").addClass("glyphicon-remove");
					$("#8char").css("color","#FF0004");
				}
				
				if(ucase.test($("#password1").val())){
					$("#ucase").removeClass("glyphicon-remove");
					$("#ucase").addClass("glyphicon-ok");
					$("#ucase").css("color","#00A41E");
				}else{
					$("#ucase").removeClass("glyphicon-ok");
					$("#ucase").addClass("glyphicon-remove");
					$("#ucase").css("color","#FF0004");
				}
				
				if(lcase.test($("#password1").val())){
					$("#lcase").removeClass("glyphicon-remove");
					$("#lcase").addClass("glyphicon-ok");
					$("#lcase").css("color","#00A41E");
				}else{
					$("#lcase").removeClass("glyphicon-ok");
					$("#lcase").addClass("glyphicon-remove");
					$("#lcase").css("color","#FF0004");
				}
				
				if(num.test($("#password1").val())){
					$("#num").removeClass("glyphicon-remove");
					$("#num").addClass("glyphicon-ok");
					$("#num").css("color","#00A41E");
				}else{
					$("#num").removeClass("glyphicon-ok");
					$("#num").addClass("glyphicon-remove");
					$("#num").css("color","#FF0004");
				}
				
				if($("#password1").val() == $("#password2").val()){
					$("#pwmatch").removeClass("glyphicon-remove");
					$("#pwmatch").addClass("glyphicon-ok");
					$("#pwmatch").css("color","#00A41E");
				}else{
					$("#pwmatch").removeClass("glyphicon-ok");
					$("#pwmatch").addClass("glyphicon-remove");
					$("#pwmatch").css("color","#FF0004");
				}
			});
		</script>
	</body>
</html>
