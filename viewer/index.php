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
		<link href="../assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			input[type="text"], textarea:read-only:not([read-only="false"]) { color: black; }
			.alert {
				padding: 15px;
				margin-left: 0px;
				margin-bottom: 20px;
				border: 1px solid transparent;
				border-radius: 4px
			}
			.alert-success {
				background-color: #dff0d8;
				border-color: #d6e9c6;
				color: #3c763d
			}
			textarea {
				resize: none;
			}
		</style>
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
							User (Requestor)
						</small>
					</a>
				</div>
				<!--<div class="navbar-buttons navbar-header pull-left" role="navigation">
					<div id="message"></div>
				</div>-->
				<div class="navbar-buttons navbar-header pull-right"> 
					<ul class="nav ace-nav">
						<li class="green">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span class="user-info">
								<?php
									$nik = $_SESSION['user_view'];
									$query = pg_query($conn, "SELECT * FROM tbl_r_general_user WHERE nik = '$nik' ");
									$result = pg_fetch_array($query);				
									$dept =  $result['department'];
									$id_code =  $result['id_user'];
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
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								Notification Center
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php									
									$query = pg_query($conn, "SELECT count(header_id) as notif FROM public.vw_t_approvaldocument where requestor_id = $id_code");
									while($data = pg_fetch_array($query)){
										echo '<div class="col-lg-3 col-md-6">';
											echo '<div class="panel panel-info">';
												echo '<div class="panel-heading">';											
													echo '<div class="row">';
														echo '<div class="col-xs-3">';
															echo '<i class="fa fa-list-alt fa-5x"></i>';
														echo '</div>';
														echo '<div class="col-xs-9 text-right">';
															echo '<div class="huge">'.$data['notif'].'</div>';
															echo '<div>List Document !</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
												echo '<a href="index.php?last_step_dokumen=0">';
													echo '<div class="panel-footer">';
														echo '<span class="pull-left">View Details</span>';
														echo '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>';
														echo '<div class="clearfix"></div>';
													echo '</div>';
												echo '</a>';
											echo '</div>';
										echo '</div>';
									}
																		
									if ((pg_num_rows($query) == 0)){
											echo '<div class ="huge"><center>Empty Notification</div>';
									}
								?>
							</div>
						</div>
						<div id="detailNotif">
							<div class="row">
								<?php
									if(isset($_GET['last_step_dokumen'])){
										$last_step_dokumen = $_GET['last_step_dokumen'];
										function date_convert($date) {
											$newDateString = date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
											return $newDateString;
										}	
										
										if ($last_step_dokumen == 0) {
											echo'<div class="table-header">
												Table List Document Your Requestor
											</div>';
										} 										
										echo'
										<div class="box-body table-responsive">
											<table id="dynamic-table_detail" class="table table-bordered table-hover " cellspacing="0" width="100%">
												<thead>
													<tr>		
														<th>NO</th>
														<th>CREATED DATE</th>
														<th>CREATED BY</th>													
														<th>MR NO.</th>
														<th>PR NO.</th>
														<th>MR DESC.</th>
														<th>STATUS</th>
														<th class="nosort"><center>Action</th>
													</tr>
												</thead>
												<tbody>';
													$no = 1;
													if ($last_step_dokumen == 0) {
														$query = pg_query($conn, "SELECT created_date, pr_no, user_name, header_id, mr_no, purpose, header_id, trim(step_description) as status FROM public.vw_t_approvaldocument where requestor_id = $id_code order by created_date desc, created_by; ");																							} 													
													while ($result = pg_fetch_array($query)){ echo' 
														<tr>	
															<td><center><span class="badge badge-info">'.$no.'</span></td>																		
															<td>'.date_convert($result['created_date']).'</td>
															<td>'.$result['user_name'].'</td>
															<td>'.$result['mr_no'].'</td>
															<td>'.$result['pr_no'].'</td>
															<td>'.$result['purpose'].'</td>
															<td>'.$result['status'].'</td>
															<td><center><a href="req_form_request.php?header_id='.$result['header_id'].'"><input type="submit" value="View Detail" name="finish" class="btn btn-success btn-xs"/></a></td>													
														</tr>';
													$no++;
													}echo'
												</tbody>
											</table>
										</div><br/>';									
									}
									echo '</table>';
								?>		
							</div>
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
		<!-- ace settings handler -->
		<script src="../assets/js/ace-extra.min.js"></script>
		<script src="../assets/js/jquery.2.1.1.min.js"></script>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='../assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<!-- ace scripts -->
		<script src="../assets/js/ace-elements.min.js"></script>
		<script src="../assets/js/ace.min.js"></script>
		<!-- page specific plugin scripts -->
		<script src="../assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
		<script src="../assets/js/plugins/datatable/jquery.dataTables.bootstrap.min.js"></script>
		<script src="../assets/js/plugins/ckeditor/ckeditor.js"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="../assets/js/plugins/bootstrap3-wysihtml5.all.min.js"></script>
		<script type="text/javascript">
			$(document).ready (function () {
				var notif = "user_notif.php";
				$("#message").load(notif);
							
				$("#dynamic-table_detail").dataTable({
					'aoColumnDefs': [{
						'bSortable': false,
						'aTargets': ['nosort']
					}]
				});
				$("#success-alert").alert();
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").slideUp(500);
				});   
				CKEDITOR.replace( 'editor1', {
					removePlugins: 'elementspath',
					resize_enabled: false,
					height: '300px',
					toolbar: [
						{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste','-', 'Undo', 'Redo' ] },
						{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
						{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
						{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
						{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
						{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
						{ name: 'others', items: [ '-' ] },
						{ name: 'about', items: [ 'About' ] }
					]
				});
				//bootstrap WYSIHTML5 - text editor
				$(".textarea").wysihtml5();
			});
		</script>
	</body>
</html>
