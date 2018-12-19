<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
			
	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');
	$noPR = "Generate By Purchasing";
	
	$dept_id = $_SESSION['department'];
	$query = pg_query($conn, "select * from tbl_r_departemen where departemen_id = $dept_id ");
	$dept_query = pg_fetch_array($query);
	$departemen_name = $dept_query['departemen_name'];
	
	$user = pg_escape_string($_SESSION['user_depthead']);
	$header_id = $_GET['header_id'];
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
							User (Approver)
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
									$nik = $_SESSION['user_depthead'];
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
						<a href="form_request.php">
							<i class="menu-icon fa fa-stack-exchange"></i>
							<span class="menu-text"> Form Request</span>
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
							<li class="active">Approval Document</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								Approval Document
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<div class="panel panel-primary">
									<div class="panel-heading">Purchase Requisition Application Form</div>
									<!--<form class="form-horizontal style-form" action="" method="get"> -->
		
									<div class="panel-body">
										<div class="form-group">
											<?php										
												$query = pg_query($conn, "SELECT * FROM vw_t_approvaldocument WHERE header_id = {$header_id} and nik_approval = '$nik'");
												$view = pg_fetch_array($query);
																										
											?>
											<input type="hidden" id="headerid" name="headerid" value="<?php echo $header_id;?>" readonly/>
											<input type="hidden" id="deptid" name="deptid" value="<?php echo $dept_id;?>" readonly/>
											<input type="hidden" id="user" name="user" value="<?php echo $user;?>" readonly/>
											<input type="hidden" id="datetime" name="datetime" value="<?php echo $datetime;?>" readonly/>
											<table cellpadding="6" class="table table-bordered">
												<tr>
													<td>Section</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_section" name="txt_section" value="<?php echo $view['user_section'];?>"/>
													</td>

													<td colspan="3">Suggested Vendor :</td>

													<td>Requestor</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_Requestor" name="txt_Requestor" value="<?php echo $view['requestor_id'];?>" readonly/>															
													</td>
												</tr>
												<tr>
													<td>Department</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_Department" name="txt_Department" value="<?php echo $view['user_department'];?>" readonly/>
													</td>

													<td colspan="3">
													<textarea rows="3" cols="40" class="k-textbox textbox-custom" id="txt_suggestedVendor" name="txt_suggestedVendor"><?php echo $view['suggested_vendor'];?></textarea>
												</td>
													
													<td>Date</td>
													<td>:</td>
													<td>
														<input type="date" id="txt_date" name="txt_date" class="k-textbox textbox-custom" value="<?php echo $view['created_date'];?>" readonly/>
														<span class="error"><?php echo $error_date?></span>
													</td>
												</tr>
												<tr>
													<td>Cost Center</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_CostCenter" name="txt_CostCenter" value="<?php echo $view['cost_center'];?>"/>
													</td>
													
													<td>MR No.</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_NoMR" name="txt_NoMR" value="<?php echo $view['mr_no'];?>" readonly/>
													</td>

													<td>PR No.</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_NoPR" name="txt_NoPR" value="<?php echo $view['pr_no'];?>" readonly/>
													</td>
												</tr>
											</table>		

											<?php
												function date_convert($date) {
													$newDateString = date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
													return $newDateString;
												}
												$query = pg_query($conn, "SELECT * FROM vw_t_approvaldocument WHERE header_id = {$header_id} and nik_approval = '$nik' ");
												$result = pg_fetch_array($query);				
												$created_by =  $result['created_by'];
												
												$cek = pg_query($conn, "SELECT * FROM tbl_t_request_detail where header_id = {$header_id} and trim(created_by) = trim('$created_by') ");
												$cek_row = pg_num_rows($cek);
												echo '
												<div class="table-header">
													
												</div>
												<div class="box-body table-responsive">
													<table id="dynamic-table_detail" class="table table-bordered table-hover " cellspacing="0" width="100%">
														<thead>
															<tr>		
																<th>NO</th>
																<th>ITEM CODE</th>
																<th>DESCRIPTION</th>
																<th>REQ QTY</th>
																<th>UOM</th>
																<th>LAST ORDER DATE</th>
																<th>LAST ORDER QTY</th>
																<th>MIN. STOCK</th>
																<th>MAX. STOCK</th>
																<th>STOCK BAL.</th>
																<th>NEEDED DATE</th>
																<th>PURPOSE</th>
															</tr>
														</thead>
														<tbody>';
															$no = 1;
															$query = pg_query($conn, "SELECT * FROM tbl_t_request_detail where header_id = {$header_id} and created_by = '$created_by' ");
															while ($result = pg_fetch_array($query)){ echo' 
																<tr>	
																	<td><center><span class="badge badge-info">'.$no.'</span></td>																		
																	<td>'.$result['item_no'].'</td>
																	<td>'.$result['desc_material'].'</td>
																	<td>'.$result['req_qty'].'</td>
																	<td>'.$result['uom'].'</td>
																	<td>'.date_convert($result['last_order_date']).'</td>
																	<td>'.$result['last_order_qty'].'</td>
																	<td>'.$result['min_stock'].'</td>
																	<td>'.$result['max_stock'].'</td>
																	<td>'.$result['stock_bal'].'</td>
																	<td>'.date_convert($result['needed_date']).'</td>
																	<td>'.$result['purpose'].'</td>																		
																</tr>';
															$no++;
															} 																
														echo'</tbody>
													</table>
												</div><br/>';
											?>
										</div>
									</div>	
									<!--</form> -->
									&nbsp; &nbsp; &nbsp;
									<a href="index.php" class="btn btn-xs btn-warning"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; Back</a>							
									<button id="approve_data" name="approve_data"  class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i> &nbsp; Approve</button>
									<button id="reject_data" name="reject_data" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> &nbsp; Reject</button>						
								</div>
							</div>
						</div>
					</div>
					
					<!-- The Modal -->
					<div id="myModalApprove" class="modal">
					  <!-- Modal content -->
						<div class="modal-content">
							<div class="panel panel-primary">
								<div class="panel-heading">Purchase Requisition Approve</div>
								<div class="row">
									</br>
									&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
									Remarks Approve :
									</br>
									&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
									<textarea rows="4" cols="70" class="k-textbox textbox-custom" id="txt_remarksApprove" name="txt_remarksApprove"></textarea>
								</div>
								</br>
								&nbsp; &nbsp; &nbsp;<button type="button" id="approve_data" name ="approve_data" class="btn btn-success btn-xs" onclick="approveRow()"><span class="glyphicon glyphicon-ok"></span>&nbsp; Approve</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning btn-xs" onclick="cancel()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>	
							</div>
						</div>
					
					</div>
					
					<!-- The Modal -->
					<div id="myModalReject" class="modal">
					  <!-- Modal content -->
						<div class="modal-content">							
							<div class="panel panel-primary">
								<div class="panel-heading">Purchase Requisition Reject</div>
								<div class="row">
									</br>
									&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
									Remarks Reject :
									</br>
									&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
									<textarea rows="4" cols="70" class="k-textbox textbox-custom" id="txt_remarksReject" name="txt_remarksReject"></textarea>
								</div>
								</br>
								&nbsp; &nbsp; &nbsp;<button type="button" id="reject_data" name ="reject_data" class="btn btn-danger btn-xs" onclick="rejectRow()"><span class="glyphicon glyphicon-remove"></span>&nbsp; Reject</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning btn-xs" onclick="cancel()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>	
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
			
			function approveRow(){
				var txt_option			= "approve";
				var txt_status_doc		= "1";
				var txt_status_desc		= "Approve by Dept. Head";
				var txt_remarks			= $.trim($("#txt_remarksApprove").val());
				var txt_modified_date	= $("#datetime").val();
				var txt_modified_by		= $("#user").val();
				var txt_headerid		= $("#headerid").val();
				
				if (txt_remarks != ""){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
					 //var dataString = JSON.stringify(postData);
					var dataString = 'option='+ txt_option + '&status_doc='+ txt_status_doc + '&status_desc='+ txt_status_desc + '&remarks='+ txt_remarks + '&modified_date='+ txt_modified_date 
									+ '&modified_by='+ txt_modified_by + '&headerid='+ txt_headerid;
					console.log(dataString);
					$.ajax({
						type: 'POST',
						url: 'Controllers/submit_form_request.php',
						//data: {'myData':dataString},
						data: dataString,
						cache: false,
						success: function (result) {
							alert(result);
							window.location.href = "index.php";
							
						},
						error: function (e) {
							console.log(e.message);
							alert("error while proccess !");
						}
					});	
				} else {
					alert("Field Remarks is Empty!!!");
				}
								
			}
			
			function rejectRow(){
				var txt_option			= "reject";
				var txt_status_doc		= "0";
				var txt_status_desc		= "Reject by Dept. Head";
				var txt_remarks			= $("#txt_remarksReject").val();
				var txt_modified_date	= $("#datetime").val();
				var txt_modified_by		= $("#user").val();
				var txt_headerid		= $("#headerid").val();
				
				if (txt_remarks != ""){ 
					 //var dataString = JSON.stringify(postData);
					var dataString = 'status_doc='+ txt_status_doc + '&status_desc='+ txt_status_desc + '&remarks='+ txt_remarks + '&modified_date='+ txt_modified_date 
									+ '&modified_by='+ txt_modified_by + '&headerid='+ txt_headerid;
					console.log(dataString);
					$.ajax({
						type: 'POST',
						url: 'approval.php',
						//data: {'myData':dataString},
						data: dataString,
						cache: false,
						success: function (result) {
							alert(result);
							modalReject.style.display = "none";
							window.location.href = "index.php";
						},
						error: function (e) {
							console.log(e.message);
							alert("error while proccess !");
						}
					});	
				} else {
					alert("Field Remarks is Empty!!!");
				}
							
			}
			
			function cancel() {
				modalApp.style.display = "none";
				modalReject.style.display = "none";
				$("#txt_remarksApprove").val("");			
				$("#txt_remarksReject").val("");
			}
			
			// Get the modal
			var modalApp = document.getElementById('myModalApprove');
			var modalReject = document.getElementById('myModalReject');

			// Get the button that opens the modal
			var btnApp = document.getElementById("approve_data");
			var btnReject = document.getElementById("reject_data");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			// When the user clicks the button, open the modal 
			btnApp.onclick = function() {
				$("#txt_remarksApprove").val("");	
				modalApp.style.display = "block";
			}
			
			btnReject.onclick = function() {
				$("#txt_remarksReject").val("");	
				modalReject.style.display = "block";
			}
			
		</script>
	</body>
</html>

