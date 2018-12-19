<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Dashboard">
		<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

		<title>User</title>

		<!-- Bootstrap core CSS -->
		<link href="../assets/css/bootstrap.css" rel="stylesheet">
		<!--external css-->
		<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="../assets/iCheck/all.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/zabuto_calendar.css">
		<link rel="stylesheet" type="text/css" href="../assets/js/gritter/css/jquery.gritter.css" />
		<link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">    
		
		<!-- Custom styles for this template -->
		<link href="../assets/css/style.css" rel="stylesheet">
		<link href="../assets/css/style-responsive.css" rel="stylesheet">
		<link rel="shortcut icon" href= "../assets/img/masplene.ico" />

		<script src="../assets/js/chart-master/Chart.js"></script>
	</head>

	<body>
		<section id="container" >
			<!--header start-->
			<header class="header black-bg">
				<div class="sidebar-toggle-box">
					  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
				</div>
				<!--logo start-->
				<a href="index.php" class="logo"><b>User</b></a>
				<!--logo end-->
				<div class="top-menu">
					<ul class="nav pull-right top-menu" >
						<li><a class="logout" href="../index.php">Logout</a></li>
					</ul>
				</div>
			</header>
			<!--header end-->
			<!--MAIN SIDEBAR MENU -->
			<!--sidebar start-->
			<aside>
				<div id="sidebar"  class="nav-collapse ">
					<!-- sidebar menu start-->
					<ul class="sidebar-menu" id="nav-accordion">
						<p class="centered"><a href="#"><img src="../assets/img/user.png" class="img-circle" width="60"></a></p>
						<h5 class="centered">
							<?php echo $_SESSION['user'].'</br>'; 								
								$query = pg_query($conn, "SELECT * FROM user_comp WHERE id_user='{$_SESSION['user']}'");
								$username = pg_fetch_array($query);
								echo $username['user_name'];
								
								$query = pg_query($conn, "SELECT coalesce(max(header_id),0)+1 as header_id FROM tbl_t_request_header");
								$maxid = pg_fetch_array($query);								
								$_SESSION['header_id']= $maxid['header_id'];								
							?>
						</h5>
						<li class="mt">
							<a href="index.php">
								<i class="fa fa-home"></i>
								<span>Home</span>
							</a>
						</li>
						<li class="sub-menu">
							<a class="active"  href="form_request.php" >
								<i class="fa fa-book"></i>
								<span>Form Request</span>
							</a>
						</li>
						<li class="sub-menu">
							<a href="view_report.php" >
								<i class="fa fa-table"></i>
								<span>View Report</span>
							</a>
						</li>
					</ul>
				 <!-- sidebar menu end-->
				</div>
			</aside>
			<!--sidebar end-->
			
			<!-- MAIN CONTENT -->
			<!--main content start-->
			<section id="main-content">
				<section class="wrapper">
					<div class="row">
						  <form method="post" action="add-data.php">
							<table class='table table-bordered'>
								<tr>
									<td>Enter how many records you want to insert</td>
								</tr>

								<tr>
									<td>
									<input type="text" name="no_of_rec" placeholder="how many records u want to enter ? ex : 1 , 2 , 3 , 5" maxlength="2" pattern="[0-9]+" class="form-control" required />
									</td>
								</tr>

								<tr>
								<td>
									<button type="submit" name="btn-gen-form" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> &nbsp; Generate</button> 
									<a href="form_request.php" class="btn btn-large btn-success"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; Back to Form Request</a>
								</td>
								</tr>
							</table>
						</form>
					</div>
					
				</section>
			</section>
			</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>
			<!--main content end-->
			<!--footer start-->
			<footer class="site-footer">
				<div class="text-center">
				  © 2017 Copyright: PT POLYTAMA PROPINDO
					<a href="index.php" class="go-top">
						<i class="fa fa-angle-up"></i>
					</a>
				</div>
			</footer>
			<!--footer end-->
		</section>

		<!-- js placed at the end of the document so the pages load faster -->
		<script src="../assets/js/jquery.js"></script>
		<script src="../assets/js/jquery-1.8.3.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="../assets/js/jquery.scrollTo.min.js"></script>
		<script src="../assets/js/jquery.nicescroll.js" type="text/javascript"></script>
		<script src="../assets/js/jquery.sparkline.js"></script>
		<!--common script for all pages-->
		<script src="../assets/js/common-scripts.js"></script>
		<script src="../assets/iCheck/icheck.min.js"></script>
		<script type="text/javascript">
			
		</script>
		<style type="text/css">
			.error {
				color: red;
				padding-left: .5em;
			}
		</style>
	</body>
</html>

