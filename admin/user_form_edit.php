<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
				
	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');
	
	$user = pg_escape_string($_SESSION['admin']);
	$rowid = $_GET['rowid'];
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
						
			.modal {
				display: none; /* Hidden by default */
				position: fixed; /* Stay in place */
				z-index: 1; /* Sit on top */
				padding-top: 100px; /* Location of the box */
				left: 0;
				top: 0;
				width: 100%; /* Full width */
				height: 850px; /* Full height */
				overflow: auto; /* Enable scroll if needed */
				background-color: rgb(0,0,0); /* Fallback color */
				background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
			}

			/* Modal Content */
			.modal-content {
				position: relative;
				background-color: #fefefe;
				margin: auto;
				padding: 0;
				border: 1px solid #888;
				width: 80%;
				box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
				-webkit-animation-name: animatetop;
				-webkit-animation-duration: 0.4s;
				animation-name: animatetop;
				animation-duration: 0.4s
			}

			/* The Close Button */
			.close {
				color: white;
				float: right;
				font-size: 28px;
				font-weight: bold;
			}

			.close:hover,
			.close:focus {
				color: #000;
				text-decoration: none;
				cursor: pointer;
			}

			.modal-header {
				padding: 2px 16px;
				background-color: #5cb85c;
				color: white;
			}

			.modal-body {padding: 2px 16px;}

			.modal-footer {
				padding: 2px 16px;
				background-color: #5cb85c;
				color: white;
			}
			.input-disabled{background-color:#d60202;border:1px solid #ffffff;padding:2px 1px;}

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
							Administrator
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
									$nik = $_SESSION['admin'];
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
					<li class="">
						<a href="index.php">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Home</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="active">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cogs"></i>
							<span class="menu-text">System Config</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>
						<b class="arrow"></b>
						<ul class="submenu">
							<li class="active">
								<a href="view_user.php">
									<i class="menu-icon fa fa-user"></i>Application User
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="view_user_workflow.php">
									<i class="menu-icon fa fa-link"></i>Setting Workflow User
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="">
						<a href="sync.php">
							<i class="menu-icon fa fa-refresh"></i>
							<span class="menu-text"> Sync Oracle</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="view_report.php">
							<i class="menu-icon fa fa-th-list"></i>
							<span class="menu-text"> View Report </span>
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
								<i class="ace-icon fa fa-home"></i>
								<a href="index.php">Home</a>
							</li>							
							<li class="active">
								<i class="menu-icon fa fa-user"></i>
								<a href="view_user.php">Application User</a>
							</li>
							<li class="active">User Form</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								User Form
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Please fill in to create a user !
								</small>
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<div class="form-horizontal style-form">
									<?php										
												$query = pg_query($conn, "SELECT * FROM tbl_r_general_user WHERE rowid = {$rowid}");
												$view = pg_fetch_array($query);
																										
											?>
									<!--<form class="form-horizontal style-form"> -->
										<div class="panel-body">
											<input type = "hidden" class="k-textbox textbox-custom" id="userlogin" name="userlogin" value="<?php echo $nik;?>"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="date" name="date" value="<?php echo $date;?>"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="nik" name="nik" value="<?php echo $view['nik'];?>"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="section" name="section" value="<?php echo $view['section'];?>"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="id_user" name="id_user" value="<?php echo $view['id_user'];?>"/> </br>
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Username</label>
												<div class="col-sm-3">
													<input type="text" id="user" class="form-control" name="user" placeholder="Search Here" value="<?php echo $view['user_name'];?>"/>
												</div>
												<div class="col-sm-1">
													<button type="button" id="searchRequestor" name ="searchRequestor" class="btn btn-sm" onclick="searchRequestor()"><span class="glyphicon glyphicon-search"></span></button>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Department</label>
												<div class="col-sm-3">
													<input type="text" id="dept" class="form-control" name="dept" value="<?php echo $view['department'];?>" readonly/>
												</div>
											</div>										
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Password</label>
												<div class="col-sm-3">
													<input type="text" id="password" class="form-control" name="password" value="<?php echo $view['password'];?>" readonly/>
												</div>
											</div>
											<form id="myForm">
												<div class="form-group">
													<label class="col-sm-2 col-sm-2 control-label ">Level</label>
													<div class="col-sm-10">
														<div class="radio">
															<label>
																<input type="radio" name="level" class='flat-red' value="user"> User
															</label>
														</div>
														<div class="radio">
															<label>	
																<input type="radio" name="level" class='flat-red' value="admin"> Admin
															</label>
														</div>
														<div class="radio">
															<label>	
																<input type="radio" name="level" class='flat-red' value="user_depthead">  Approver
															</label>
														</div>
														<div class="radio">
															<label>	
																<input type="radio" name="level" class='flat-red' value="user_pur">  Purchasing
															</label>
														</div>
														<div class="radio">
															<label>	
																<input type="radio" name="level" class='flat-red' value="user_view">  Requestor
															</label>
														</div>
														<span class="error"><?php echo $error_level?></span>
													</div>	
												</div>
												<div class="form-group">
													<label class="col-sm-2 col-sm-2 control-label ">Location</label>
													<div class="col-sm-10">
														<div class="radio">
															<label>
																<input type="radio" name="location" class='flat-red' value="122"> HO/Jakarta
															</label>
														</div>
														<div class="radio">
															<label>	
																<input type="radio" name="location" class='flat-red' value="121"> Site/Balongan
															</label>
														</div>												
													</div>	
												</div>
											</form>
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-2 col-md-3">
													<button name="clear" class="btn btn-default btn-sm " onclick="cancelInsert()">Clear</button>								
													<button type="submit" id="submit" name ="save" class="btn btn-success btn-sm" onclick="submit()">Save</button>
												</div>
											</div>
										</div>	
									<!--</form>
										&nbsp; &nbsp; &nbsp;
										<button name="clear" class="btn btn-default btn-sm " onclick="cancelInsert()">Clear</button>								
										<button type="submit" id="submitDraft" name ="save" class="btn btn-warning btn-sm" onclick="submitDraft()">Save as Draft</button>
										<button type="submit" id="submit" name ="save" class="btn btn-success btn-sm" onclick="submitDeptHead()">Send to Dept Head</button>
										<input type="button"  class="btn btn-info" value="Print" onclick="PrintDoc()" /> -->						
								</div>
							</div>
						</div>
					</div>
					
					<!-- The Modal -->
					<div id="myModal" class="modal">
						<!-- Modal content -->
						<div class="modal-content">
							<span class="close">&times;</span>
							<div class="panel panel-primary">							
								<div class="row" id="user_table">
									
								</div>
								</br>
								<button type="button" id="cancel" name="cancel" class="btn btn-danger btn-xs" onclick="cancelRequestor()"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Close</button>	
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
				$("#dynamic-table_detail").dataTable({
					'aoColumnDefs': [{
						'bSortable': false,
						'aTargets': ['nosort']
					}]
				});
				
				$("#dynamic-tableRequestor").dataTable({
					'aoColumnDefs': [{
						'bSortable': false,
						'aTargets': ['nosort']
					}]
				});
				
				$("#dynamic-table").dataTable({
					"scrollX": true,
					'aoColumnDefs': [{
						'bSortable': false,
						'aTargets': ['nosort']
					}]
				}).columnFilter({
					aoColumns: [
						null,
						null,
						null,
						null,
						{ type: "select" },
						null,
						null
					]
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
				CKEDITOR.replace( 'editor2', {
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
			
			// Get the modal
			var myModalRequestor = document.getElementById('myModal');

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				myModalRequestor.style.display = "none";
				initialize()
			}			
			
			function searchRequestor(){
				$.ajax({
					type: 'GET',
					url: 'Controllers/user_table.php',
					data: {
						user: $("#user").val()
					},
					cache: false,
					success: function (result) {
						$("#user_table").html(result);		
						myModalRequestor.style.display = "block";
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});	
			}		

			function cancelRequestor(){
				myModalRequestor.style.display = "none";
			}
			
			function selectRequestor(){
				//alert('select');
				var table_id = document.getElementById('dynamic-tableRequestor');

				table_id.onclick = function (event) {
					event = event || window.event; //IE8
					var target = event.target || event.srcElement;
					while (target && target.nodeName != 'TR') { // find TR
						target = target.parentElement;
					}
					//if (!target) { return; } //tr should be always found
					var cells = target.cells; //cell collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableRowElement
					//var cells = target.getElementsByTagName('td'); //alternative
					if (!cells.length || target.parentNode.nodeName == 'THEAD') {
						return;
					}
					var user = document.getElementById('user');
					var section = document.getElementById('section');
					var id_user = document.getElementById('id_user');
					var nik = document.getElementById('nik');
					var dept = document.getElementById('dept');
					
					id_user.value = cells[1].innerHTML;
					nik.value = cells[2].innerHTML;
					user.value = cells[3].innerHTML;
					section.value = cells[5].innerHTML.replace("&amp;", "&");
					dept.value = cells[4].innerHTML.replace("&amp;", "&");
					//console.log(target.nodeName, event);
				};
				myModalRequestor.style.display = "none";
			}	
						
			function cancel() {
				modal.style.display = "none";				
				initialize()				
			}
			
			function submit(){	
				var flag = "1";
				var txt_user		= $("#user").val();
				var txt_section		= $("#section").val().replace("&", "|");
				var txt_id_user 	= $("#id_user").val();
				var txt_nik			= $("#nik").val();
				var txt_dept		= $("#dept").val().replace("&", "|");
				var txt_password	= $("#password").val();
				var txt_level		= $('input[name="level"]:checked').val();
				var txt_location	= $('input[name="location"]:checked').val();
				var txt_date		= $("#date").val();
				var txt_userlogin	= $("#userlogin").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'id_user='+ txt_id_user + '&nik='+ txt_nik + '&user='+ txt_user + '&dept='+ txt_dept 
								+ '&section='+ txt_section + '&password='+ txt_password + '&level='+ txt_level + '&location='+ txt_location 
								+ '&txt_date='+ txt_date + '&txt_userlogin='+ txt_userlogin;;
				console.log(dataString);
				
				if (txt_user == '') {
					flag = "0";
					//document.getElementById("user").style.backgroundColor = "red";
				}else {
					document.getElementById("user").style.backgroundColor = "";
					if (txt_dept == '') {
						flag = "00";
						//document.getElementById("dept").style.backgroundColor = "red";
					}else {
						if (txt_level == undefined) {					
							flag = "000";
						} else {
							if (txt_location == undefined) {					
								flag = "0000";
							}
						}
					}
				}
				
				if (flag == "1"){
					$.ajax({
					type: 'POST',
					url: 'Controllers/adduser.php',
					data: {'myData':dataString},
					data: dataString,
					cache: false,
					success: function (result) {
						alert(result);
						window.location.href = "view_user.php";
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});
				} else {
					if (flag == "0"){
						alert("Please Complete the Username Box!!!");
					} else if (flag == "00"){
						alert("Please Complete the Department Box!!!");						
					} else if (flag == "000"){
						alert("Please Complete the Level Box!!!");
					} else if (flag == "0000"){
						alert("Please Complete the Location Box!!!");
					}
				}
			}			
					
			function cancelInsert(){
				window.location.href = "user_form.php";					
			}
			
		</script>
	</body>
</html>

