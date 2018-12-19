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
		<link rel="stylesheet" type="text/css" href="../assets/iCheck/all.css">
		<link rel="shortcut icon" href= "../assets/img/masplene.ico" />
		<link href="../assets/css/custom.css" rel="stylesheet">
		<link rel="shortcut icon" href= "../assets/img/masplene.ico" />
		<!-- text fonts -->
		<link rel="stylesheet" href="../assets/fonts/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="../assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
		<style type="text/css">
			.error {
				color: red;
				padding-left: .5em;
			}
			input[type="text"]:read-only:not([read-only="false"]) { color: black; }
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
							<i class="fa fa-cog"></i>
							User Employee
						</small>
					</a>
				</div>
				<div class="navbar-buttons navbar-header pull-right"> 
					<ul class="nav ace-nav">
						<li class="green">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span class="user-info">
								<?php
									$id = $_SESSION['user'];
									$query = pg_query($conn, "SELECT * FROM login l JOIN employee e ON l.id_user = e.id_code WHERE id_user=$id ");
									$result = pg_fetch_array($query);				
									$dept =  $result['department_id'];
									echo "<small>".$id."</small>".$result['name'];
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
					<li class="">
						<a href="index.php">
							<i class="menu-icon fa fa-file-text-o"></i>
							<span class="menu-text"> Trouble Ticket</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="user_troubleshooting.php">
							<i class="menu-icon fa fa-envelope"></i>
							<span class="menu-text"> Troubleshooting</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="active">
						<a href="view_assets.php">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text"> View Assets </span>
						</a>
						<b class="arrow"></b>
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
								<i class="ace-icon fa fa-desktop home-icon"></i>
								<a href="#">View Assets</a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								View Assets
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php
									function date_convert($date) {
										$newDateString = date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
										return $newDateString;
									}
									$asset1 = pg_query($conn, "SELECT * FROM system_configuration WHERE id_user = $id ");
									$sys_config = pg_fetch_array($asset1);	
									$asset2 = pg_query($conn, "SELECT * FROM hardware_configuration WHERE id_user = $id ");
									$hw_config = pg_fetch_array($asset2);	
									$asset3 = pg_query($conn, "SELECT * FROM install WHERE id_user = $id ");
									$install = pg_fetch_array($asset3);	
							?>	
									
								<div class="widget-box">
									<div class="widget-header">
										<h4 class="widget-title">System Configuration</h4>
										<div class="widget-toolbar">
											<a href="#" data-action="collapse">
												<i class="ace-icon fa fa-chevron-up"></i>
											</a>
										</div>
									</div>
									<div class="widget-body">
										<div class="widget-main">		
											<div class="form-horizontal style-form">
												<div class="panel-body">
												<?php
												if($sys_config ){
													echo'
													<div class="form-group">
														<label class="col-sm-2 col-sm-2 control-label ">User ID</label>
														<div class="col-sm-3">
															<input type="text" class="form-control" name="user_name" value="'.$sys_config['id_user'].'" readonly />
														</div>
														<label class="col-sm-2 col-sm-2 control-label ">Internal Email</label>
														<div class="col-sm-3">
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="ace-icon fa fa-envelope" aria-hidden="true"></i>
																</span>
																<input type="text" maxlength="20" class="form-control" name="inter_email" value="'.$sys_config['internal_email'].'" readonly/>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 col-sm-2 control-label ">Computer Name</label>
														<div class="col-sm-3">
															<input type="text" class="form-control" name="computer_name" value="'.$sys_config['computer_name'].'" readonly/>
														</div>
														<label class="col-sm-2 col-sm-2 control-label ">External Email</label>
														<div class="col-sm-3">
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="ace-icon fa fa-envelope" aria-hidden="true"></i>
																</span>
																<input type="text" class="form-control" name="exter_email" value="'.$sys_config['external_email'].'" readonly/>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 col-sm-2 control-label ">Ip Address</label>
														<div class="col-sm-3">
															<div class="input-group">
																<div class="input-group-addon">
																	<i class="fa fa-laptop"></i>
																</div>
																<input type="text" class="form-control" name="ip_address" value="'.$sys_config['ip_address'].'" readonly/>
															</div>
														</div>
														<label class="col-sm-2 col-sm-2 control-label ">Grup Name</label>
														<div class="col-sm-3">
															<input type="text" class="form-control" name="group_name" value="'.$sys_config['group_name'].'" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 col-sm-2 control-label "></label>
														<div class="col-sm-2 col-sm-2 checkbox">	
															<input disabled=""  type="checkbox" id="int_value" class="flat-red" value="int_acces" name="int_acces" ';if($sys_config['internet_acces'] == 'yes'){echo 'checked';} else {}; echo' /> Internet Access
														</div>
													</div>
													<h4 class="mb"><i class="fa fa-angle-right"></i> Network Configuration</h4>
													<div class="form-group">
														<label class="col-sm-2 col-sm-2 control-label ">Organisasi Unit</label>
														<div class="col-sm-3">
															<input type="text" class="form-control" name="org_unit" value="'.$sys_config['org_unit'].'" readonly/>
														</div>
													</div>';
												}else{
													echo '<center><h3>No Data Available</h3>';
												}
												?>
												</div>
											</div>
										</div>
									</div>
								</div>			
								<div class="widget-box">
									<div class="widget-header">
										<h4 class="widget-title">Hardware Configuration</h4>
										<div class="widget-toolbar">
											<a href="#" data-action="collapse">
												<i class="ace-icon fa fa-chevron-up"></i>
											</a>
										</div>
									</div>
									<div class="widget-body">
										<div class="widget-main">		
											<div class="form-horizontal style-form">
												<div class="panel-body">
												<?php
													if($hw_config ){
														echo'
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">Change Date</label>
															<div class="col-sm-3">
																<div class="input-group">
																	<input class="form-control date-picker"  type="text" id="date"  name="change_date" data-date-format="dd-mm-yyyy" value="'.date_convert($hw_config['change_date']).'"readonly/>
																	<span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
																</div>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">Install Date</label>
															<div class="col-sm-3">
																<div class="input-group">
																	<input class="form-control date-picker"  type="text" id="date" name="install_date" data-date-format="dd-mm-yyyy" value="'.date_convert($hw_config['install_date']).'" readonly/>
																	<span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
																</div>
															</div>
														</div>		
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">Processor</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="processor" value="'.$hw_config['processor'].'" readonly/>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">Mother Board</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="mother_board" value="'.$hw_config['mother_board'].'" readonly />
															</div>
														</div>	
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">CPU Brand Name</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="cpu_brand" value="'.$hw_config['cpu_brand'].'" readonly/>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">VGA/AGP</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="vga" value="'.$hw_config['vga_agp'].'" readonly/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">Casing Serial No.</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="casing_no"  value="'.$hw_config['casing_serial'].'" readonly/>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">Optical Drive</label>
															<div class="col-sm-3">
																<input type="text"class="form-control" name="optical_drive" value="'.$hw_config['optical_drive'].'" readonly/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">HDD Capacity</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="hdd"  value="'.$hw_config['hdd_capacity'].'" readonly/>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">Memory/Capacity</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="memory"  value="'.$hw_config['memory'].'" readonly/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">Keyboard</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="keyboard"  value="'.$hw_config['keyboard'].'" readonly/>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">Monitor</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="monitor"  value="'.$hw_config['monitor'].'" readonly/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">Mouse</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="mouse"  value="'.$hw_config['mouse'].'" readonly/>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">Printer</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="printer" value="'.$hw_config['printer'].'" readonly/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-2 col-sm-2 control-label ">Serial Number Mouse</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="sn" value="'.$hw_config['mouse_serial'].'" readonly/>
															</div>
															<label class="col-sm-2 col-sm-2 control-label ">Serial Number Printer</label>
															<div class="col-sm-3">
																<input type="text" class="form-control" name="serial_number" value="'.$hw_config['print_serial'].'" readonly/>
															</div>
														</div>';			
													}else{
														echo '<center><h3>No Data Available</h3>';
													}
												?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="widget-box">
									<div class="widget-header">
										<h4 class="widget-title">List Install Software</h4>
										<div class="widget-toolbar">
											<a href="#" data-action="collapse">
												<i class="ace-icon fa fa-chevron-up"></i>
											</a>
										</div>
									</div>
									<div class="widget-body">
										<div class="widget-main">		
											<div class="form-horizontal style-form">
												<div class="panel-body">
													<div class="box-body table-responsive">
														<table id="dynamic-table" class="table table-bordered table-striped table-hover">
															<thead>
																<tr>
																	<th>NO</th>
																	<th>INSTALL DATE</th>
																	<th>SOFTWARE</th>
																	<th>VENDOR</th>
																</tr>
															</thead>
															<tbody>
															<?php
																$row = pg_num_rows($asset3);	
																for($j = 1; $j <= $row ; $j++){
																	$software = pg_query($conn, "SELECT * FROM install i JOIN master_software s ON i.software[$j] = s.id_software WHERE id_user = $id ");
																	while($result = pg_fetch_array($software)){
																		$list_id[] = $result['id_software'];
																		$list_name[] = $result['software_name'];
																		$list_vendor[] = $result['vendor'];
																	}
																}
																$data =  count($list_id);
																for($k = 0; $k < $data ; $k++){
																	$data_software = pg_query($conn, "SELECT * FROM install WHERE id_user = $id AND '$list_id[$k]' = ANY(software) ");
																	while($result = pg_fetch_array($data_software)){
																		$list_date[$k] = $result['date_install'];
																	}
																}
																$no = 1;
																for($l = 0; $l < $data ; $l++){
																	echo'
																	<tr>
																		<td><center><span class="badge badge-info" >'.$no.'</span></td>
																		<td>'.date_convert($list_date[$l]).'</td>
																		<td>'.$list_name[$l].'</td>
																		<td>'.$list_vendor[$l].'</td>
																	</tr>';
																	$no++;
																}
															?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
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
							<span class="blue bolder">UNDIP</span>
							Informatika &copy; 2016
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
		
		<script src="../assets/js/jquery-ui.custom.min.js"></script>
		<script src="../assets/js/jquery.ui.touch-punch.min.js"></script>
		<!-- ace scripts -->
		<script src="../assets/js/ace-elements.min.js"></script>
		<script src="../assets/js/ace.min.js"></script>
		
		<!-- CUSTOM SCRIPTS -->
		<script src="../assets/js/plugins/custom.js"></script>
		
		<script src="../assets/js/plugins/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="../assets/js/plugins/datatable/jquery.dataTables.bootstrap.min.js"></script>
		<!--common script for all pages-->
		<script src="../assets/iCheck/icheck.min.js"></script>
		<script>
			$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			  checkboxClass: 'icheckbox_flat-green',
			  radioClass: 'iradio_flat-green'
			});
		</script>
	</body>
</html>

