<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
				
	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');
	
	$user = pg_escape_string($_SESSION['admin']);
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
							<li class="">
								<a href="view_user.php">
									<i class="menu-icon fa fa-user"></i>Application User
								</a>
								<b class="arrow"></b>
							</li>
							<li class="active">
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
								<i class="menu-icon fa fa-link"></i>
								<a href="setting_workflow.php">Setting Workflow User</a>
							</li>
							<li class="active">User Workflow Form</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								User Workflow  Form
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Please fill in to set workflow an user !
								</small>
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<div class="form-horizontal style-form">
									<!--<form class="form-horizontal style-form"> -->
										<div class="panel-body">
											<input type = "hidden" class="k-textbox textbox-custom" id="userlogin" name="userlogin" value="<?php echo $nik;?>"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="date" name="date" value="<?php echo $date;?>"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="nik" name="nik"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="section" name="section"/>
											<input type = "hidden" class="k-textbox textbox-custom" id="id_user" name="id_user"/> </br>
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Username</label>
												<div class="col-sm-3">
													<input type="text" id="user" class="form-control" name="user" placeholder="Search Here"/>
												</div>
												<div class="col-sm-1">
													<button type="button" id="searchRequestor" name ="searchRequestor" class="btn btn-sm" onclick="searchRequestor()"><span class="glyphicon glyphicon-search"></span></button>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Department</label>
												<div class="col-sm-3">
													<input type="text" id="dept" class="form-control" name="dept" placeholder="Search Username" readonly/>
												</div>
											</div>										
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Current Step</label>
												<div class="col-sm-3">
													<select class="form-control"  name="current_step" id="current_step">
														<option value=""> -- Select Current Step -- </option>
														<?php 
															
															$sql =  pg_query($conn, "SELECT DISTINCT current_step, step_description FROM tbl_r_general_workflow ORDER BY current_step");
															while($row = pg_fetch_array($sql)){
																	echo "<option value=\"{$row['current_step']}\">{$row['step_description']}</option>",PHP_EOL;
															}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Decision Step</label>
												<div class="col-sm-3">
													<input type="hidden" id="dec_id" class="form-control" name="dec_id" readonly/>
													<input type="text" id="dec_desc" class="form-control" name="dept" placeholder="Search Current Step" readonly/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">Next Step</label>
												<div class="col-sm-3">
													<input type="hidden" id="next_step" class="form-control" name="next_step" readonly/>
													<input type="text" id="next_step_desc" class="form-control" name="next_step_desc" placeholder="Search Current Step" readonly/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 col-sm-2 control-label ">User Approver</label>
												<div class="col-sm-3">
													<input type="text" id="userApproval" class="form-control" name="userApproval" placeholder="Search Here"/>
													<input type = "hidden" class="k-textbox textbox-custom" id="nikApproval" name="nikApproval"/>
												</div>
												<div class="col-sm-1">
													<button type="button" id="searchApproval" name ="searchApproval" class="btn btn-sm" onclick="searchApproval()"><span class="glyphicon glyphicon-search"></span></button>
												</div>
											</div>
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

					<div id="myModalDecision" class="modal">
						<!-- Modal content -->
						<div class="modal-content">
							<span class="close">&times;</span>
							<div class="panel panel-primary">							
								<div class="row" id="decision_table">
									
								</div>
								</br>
								<button type="button" id="cancelDecision" name="cancelDecision" class="btn btn-danger btn-xs" onclick="cancelDecision()"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Close</button>	
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
			
			var current_step;
			var current_stepDesc;
			// Get the modal
			var myModalRequestor = document.getElementById('myModal');
			var myModalDecision = document.getElementById('myModalDecision');
			
			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				myModalRequestor.style.display = "none";
				initialize()
			}			
			
			$("#current_step").change(function(){
				$('#decision').find('option').remove().end();
				current_step = $(this).find("option:selected").val();
				current_stepDesc = $(this).find("option:selected").text();
				$.ajax({
					type:'GET',
					url:'Controllers/get_decision.php',
					data:{
						step:current_step
					},
					cache: false,
					success: function (result) {
						$("#decision_table").html(result);
						myModalDecision.style.display = "block";
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				}); 
			});
			
			function cancelDecision(){
				myModalDecision.style.display = "none";
			}
			
			function selectDecision(){
				//alert('select');
				var table_id = document.getElementById('dynamic-table_detail');

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
					var dec_id = document.getElementById('dec_id');
					var dec_desc = document.getElementById('dec_desc');
					var next_step = document.getElementById('next_step');
					var next_step_desc = document.getElementById('next_step_desc');
					
					dec_id.value = cells[1].innerHTML;
					dec_desc.value = cells[2].innerHTML;
					next_step.value = cells[3].innerHTML;
					next_step_desc.value = cells[4].innerHTML;
					//console.log(target.nodeName, event);
				};
				myModalDecision.style.display = "none";
			}
			
			function searchApproval(){
				$.ajax({
					type: 'GET',
					url: 'Controllers/user_table.php',
					data: {
						user: $("#userApproval").val(), option: "app"
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
			
			function cancelApproval(){
				myModalRequestor.style.display = "none";
			}
			
			function selectApproval(){
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
					var userApproval = document.getElementById('userApproval');
					var nikApproval = document.getElementById('nikApproval');
					
					nikApproval.value = cells[2].innerHTML;
					userApproval.value = cells[3].innerHTML;
					//console.log(target.nodeName, event);
				};
				myModalRequestor.style.display = "none";
			}
			
			function searchRequestor(){
				$.ajax({
					type: 'GET',
					url: 'Controllers/user_table.php',
					data: {
						user: $("#user").val(), option: "user"
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
				var txt_nik			= $("#nik").val();
				var txt_curStep		= current_step;
				var txt_curStepDesc	= current_stepDesc;				
				var txt_dec_id		= $("#dec_id").val();
				var txt_dec_desc	= $("#dec_desc").val();
				var txt_next_step	= $("#next_step").val();
				var txt_nik_app		= $("#nikApproval").val();
				var txt_date		= $("#date").val();
				var txt_userlogin	= $("#userlogin").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'nik='+ txt_nik + '&current_step='+ txt_curStep + '&curStepDesc='+ txt_curStepDesc 
								+ '&dec_id='+ txt_dec_id + '&dec_desc='+ txt_dec_desc + '&next_step='+ txt_next_step 
								+ '&nikApproval='+ txt_nik_app + '&txt_date='+ txt_date + '&txt_userlogin='+ txt_userlogin;
				console.log(dataString);
								
				if (flag == "1"){
					$.ajax({
						type: 'POST',
						url: 'Controllers/addworkflow.php',
						data: {'myData':dataString},
						data: dataString,
						cache: false,
						success: function (result) {
							alert(result);
							window.location.href = "view_user_workflow.php";
						},
						error: function (e) {
							console.log(e.message);
							alert("error while proccess !");
						}
					});
				} 
			}			
					
			function cancelInsert(){
				window.location.href = "setting_workflow.php";					
			}
						
		</script>
	</body>
</html>

