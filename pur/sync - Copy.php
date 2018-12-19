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
	
	$user = pg_escape_string($_SESSION['user_pur']);
	$header_id = $_GET['header_id'];
	
	$query = pg_query($conn, "SELECT * FROM vw_t_approvaldocument WHERE header_id = {$header_id} and nik_approval = 'pur' ");
	$view = pg_fetch_array($query);
	$created_by = $view['created_by'];
	
	$query = pg_query($conn, "SELECT * FROM tbl_r_general_user WHERE trim(nik) = trim('$created_by') ");
	$view = pg_fetch_array($query);
	$departmentid = $view['department'];
		
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
				padding-top: 30px; /* Location of the box */
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
							User (Purchasing)
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
					<li class="">
						<a href="index.php">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Home</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="active">
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
								<i class="ace-icon fa fa-refresh"></i>
								<a href="#">Sync Oracle</a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								All Data Ready to/from Oracle
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<?php
									$nik = $_SESSION['user_pur'];
									function date_convert($date) {
										$newDateString = date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
										return $newDateString;
									}		
									
									echo'
									<div class="table-header">
										Table List Document Ready to Oracle
									</div>
									<div class="box-body table-responsive">
										<table id="dynamic-table_detail" class="table table-bordered table-hover " cellspacing="0" width="100%">
											<thead>
												<tr>		
													<th>NO</th>
													<th>CREATED DATE</th>
													<th>DEPT</th>
													<th>USER NAME</th>
													<th>MR NO.</th>
													<th>SUGGESTED VENDOR</th>
													<th>PURPOSE</th>
													<th class="nosort"><center>Action</th>
													
													
												</tr>
											</thead>
											<tbody>';
												$no = 1;
												$query = pg_query($conn, "SELECT * FROM public.vw_t_requisition_to_oracle order by created_date_mr desc, created_by_mr; ");										
												while ($result = pg_fetch_array($query)){ echo' 
													<tr>	
														<td><center><span class="badge badge-info">'.$no.'</span></td>																		
														<td>'.date_convert($result['created_date_mr']).'</td>
														<td>'.$result['user_department'].'</td>
														<td>'.$result['user_name'].'</td>
														<td>'.$result['mr_no'].'</td>
														<td>'.$result['suggested_vendor'].'</td>
														<td>'.$result['header_description'].'</td>
														<td><center>
															<button type="button" class="btn btn-success btn-minier" onclick="xxx()" title="Send Oracle"><i class="glyphicon glyphicon-upload "></i>&nbsp;Send Oracle</button>																				
														</td>
														
																												
													</tr>';
													$no++;
												}echo'
											</tbody>
										</table>
									</div><br/>';	
								?>		
							</div>
						</div>
						</br></br>
						<div class="row">
							<div class="col-xs-12">
								<?php
									$connOra = oci_connect('APPS', 'APPS', '192.7.1.232:1521/PROD');
									$description1 = $_REQUEST["description1"];
									If (!$connOra) 
									{
										$e = oci_error();
										trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
										echo $e;
									}	
									else 
									{	
										echo '
											<div class="clearfix">
												<div class="pull-right tableTools-container"></div>
											</div>
											<div class="table-header">
												View Tabel Material 
											</div>
											<div class="box-body table-responsive">
												<table id="dynamic-table_PR" class="table table-bordered table-striped table-hover">
													<thead>
														<tr>
															<th>NO</th>
															<th>REQUISITION HEADER ID</th>
															<th>PREPARER ID</th>
															<th>PR NO.</th>
															<th>LAST UPDATE DATE</th>
															<th class="nosort"><center>ACTION</th>
														</tr>
													</thead>			
													<tbody>';
														$no = 1;
														$sqlOra="select * from PO_REQUISITION_HEADERS_ALL ORDER BY LAST_UPDATE_DATE";					
														$stid = oci_parse($connOra,$sqlOra ); 
														oci_execute($stid);													
														while ($row=oci_fetch_assoc($stid))
														{
														echo'
														<tr>
															<td><center><span class="badge badge-info">'.$no.'</span></td>
															<td>'.$row["REQUISITION_HEADER_ID"].'</td>
															<td>'.$row["PREPARER_ID"].'</td>
															<td>'.$row["SEGMENT1"].'</td>
															<td>'.$row["LAST_UPDATE_DATE"].'</td>
															<td><center><button id="selectItem" class="btn btn-success btn-minier" onclick="selectPR()"><i class="fa fa-check "></i></button></td>
														</tr>';	
														$no++;							
														}
													echo'</tbody>
												</table>
											</div>';	
									}									
									oci_free_statement($stid);
									oci_close($connOra);
								?>			
							</div>
						</div>
					</div>								
					
					<!-- The Modal -->
					<div id="myModalReject" class="modal">
					  <!-- Modal content -->
						<div class="modal-content">
							<span class="close">&times;</span>						
							<div class="panel panel-primary">
								<div class="panel-heading">Confirmation Send to Oracle</div>
								<div class="row">
									</br>
									&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
									Do you want to send this data to Oracle?
									</br>
									<div class="row" id="requestor_table">
									
									</div>
								</div>
								</br>
								&nbsp; &nbsp; &nbsp;<button type="button" id="sendOracle" name ="sendOracle" class="btn btn-success btn-xs" onclick="sendOracle()"><span class="glyphicon glyphicon-remove"></span>&nbsp; Send to Oracle</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning btn-xs" onclick="cancelSend()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>	
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
				
				$("#dynamic-table_PR").dataTable({
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
			var modal = document.getElementById('myModal');
			var myModalItemCode = document.getElementById('myModalItemCode');
			var modalApp = document.getElementById('myModalApprove');
			var modalReject = document.getElementById('myModalReject');
			
			// Get the button that opens the modal
			var btn = document.getElementById("add_data");
			var btnApp = document.getElementById("approve_data");
			var btnReject = document.getElementById("reject_data");
			
			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modalReject.style.display = "none";
				
			}
			
			function xxx() {
				alert('select');
			}
			
			function sendToOracle(){
				alert('select');
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
					var authorization_status = cells[8].innerHTML;
					var batch_id = cells[9].innerHTML;
					var category_id = cells[10].innerHTML;
					var charge_account_id = cells[11].innerHTML;
					var created_by = cells[12].innerHTML;
					var creation_date = cells[13].innerHTML;
					var currency_code = cells[14].innerHTML;
					var deliver_to_requestor_id = cells[15].innerHTML;
					var destination_organization_id = cells[16].innerHTML;
					var destination_type_code = cells[17].innerHTML;
					var header_description = cells[6].innerHTML;
					var interface_source_code = cells[18].innerHTML;
					var item_description = cells[19].innerHTML;
					var item_segment1 = cells[20].innerHTML;
					var preparer_id = cells[21].innerHTML;
					var quantity = cells[22].innerHTML;
					var req_number_segment1 = cells[23].innerHTML;
					var requisition_header_id = cells[24].innerHTML;
					var requisition_type = cells[25].innerHTML;
					var source_type_code = cells[26].innerHTML;
					var unit_of_measure = cells[27].innerHTML;
					var unit_price = cells[28].innerHTML;
					var line_attribute9 = cells[29].innerHTML;
					var need_by_date = cells[30].innerHTML;
					var deliver_to_location_id = cells[31].innerHTML;
					
					var dataString = 'authorization_status='+ authorization_status.trim() 
					+ ' &batch_id=' + batch_id.trim()
					+ ' &category_id=' + category_id.trim()
					+ ' &charge_account_id=' + charge_account_id.trim()
					+ ' &created_by=' + created_by.trim()
					+ ' &creation_date=' + creation_date.trim()
					+ ' &currency_code=' + currency_code.trim()
					+ ' &deliver_to_requestor_id=' + deliver_to_requestor_id.trim()
					+ ' &destination_organization_id=' + destination_organization_id.trim()
					+ ' &destination_type_code=' + destination_type_code.trim()
					+ ' &header_description=' + header_description.trim()
					+ ' &interface_source_code=' + interface_source_code.trim()
					+ ' &item_description=' + item_description.trim()
					+ ' &item_segment1=' + item_segment1.trim()
					+ ' &preparer_id=' + preparer_id
					+ ' &quantity=' + quantity
					+ ' &req_number_segment1=' + req_number_segment1
					+ ' &requisition_header_id=' + requisition_header_id
					+ ' &requisition_type=' + requisition_type.trim()
					+ ' &source_type_code=' + source_type_code.trim()
					+ ' &unit_of_measure=' + unit_of_measure.trim()
					+ ' &unit_price=' + unit_price.trim()
					+ ' &line_attribute9=' + line_attribute9.trim()
					+ ' &need_by_date=' + need_by_date
					+ ' &deliver_to_location_id=' + deliver_to_location_id.trim();
					console.log(dataString);
					if (confirm('Are you sure to send this document to Oracle?')) 
					{
						$.ajax({
							type: 'POST',
							url: 'Controllers/sendToOracle.php',
							//data: {'myData':dataString},
							data: dataString,
							cache: false,
							success: function (result) {
								alert(result);
								window.location.href = "sync.php?";						
							},
							error: function (e) {
								console.log(e.message);
								alert("error while proccess !");
							}
						});						
					} else {
						// Do nothing!
					}						
				};				
			}	

			function cancelSend() {
				modalReject.style.display = "none";		
				$("#txt_remarksReject").val("");
			}			
				
			function saveFromOracle(){
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
		
					var txt_itemNo			= document.getElementById('txt_itemNo');
					var txt_Description		= document.getElementById('txt_Description');
					var txt_ReqtQty 		= document.getElementById('txt_ReqtQty');
					var txt_UOM				= document.getElementById('txt_UOM');
					var txt_neededDate		= document.getElementById('txt_neededDate');
					var txt_lastOrderQty	= document.getElementById('txt_lastOrderQty');
					var txt_lastOrderdate 	= document.getElementById('txt_lastOrderdate');
					var txt_minStock		= document.getElementById('txt_minStock');
					var txt_maxStock		= document.getElementById('txt_maxStock');
					var txt_stockBal		= document.getElementById('txt_stockBal');
					//var txt_Purpose			= document.getElementById('txt_Purpose');
					var txt_CATEGORY_ID		= document.getElementById('txt_CATEGORY_ID');
					var txt_ORGANIZATION_ID	= document.getElementById('txt_ORGANIZATION_ID');
					var txt_DESTINATION_TYPE_CODE		= document.getElementById('txt_DESTINATION_TYPE_CODE');
					var txt_rowid = document.getElementById('txt_rowid');
					
					var neededDate = cells[10].innerHTML;
					var needed = neededDate.split("-").reverse().join("-");
					var lastOrderdate = cells[5].innerHTML;
					var lastOrder = lastOrderdate.split("-").reverse().join("-");
					
					txt_itemNo.value = cells[1].innerHTML;
					txt_Description.value = cells[2].innerHTML;
					txt_ReqtQty.value = cells[3].innerHTML;
					txt_UOM.value = cells[4].innerHTML;
					txt_neededDate.value = needed;
					txt_lastOrderQty.value = cells[6].innerHTML;
					txt_lastOrderdate.value = lastOrder;
					txt_minStock.value = cells[7].innerHTML;
					txt_maxStock.value = cells[8].innerHTML;
					txt_stockBal.value = cells[9].innerHTML;
					//txt_Purpose.value = cells[11].innerHTML;
					txt_CATEGORY_ID.value = cells[12].innerHTML;
					txt_ORGANIZATION_ID.value = cells[13].innerHTML;
					txt_DESTINATION_TYPE_CODE.value = cells[14].innerHTML;
					txt_rowid.value = cells[15].innerHTML;
					
					modal.style.display = "block";
				};
				myModalRequestor.style.display = "none";
			}	
								
		</script>
	</body>
</html>

