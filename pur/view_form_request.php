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
					<li class="">
						<a href="sync.php">
							<i class="menu-icon fa fa-refresh"></i>
							<span class="menu-text"> Sync Oracle</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="active">
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
								<i class="ace-icon fa fa-stack-exchange"></i>
								<a href="view_report.php">Report</a>
							</li>
							<li class="active">View Detail Document</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								View Detail Document
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
													$query = pg_query($conn, "SELECT * FROM vw_t_document_history WHERE header_id = {$header_id} and modified_by_app = '$nik'");
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
														<input class="k-textbox textbox-custom" id="txt_section" name="txt_section" value="<?php echo $view['user_section'];?>" readonly/>
													</td>

													<td >Suggested Vendor</td>
													<td>:</td>
													<td>
														<textarea rows="2" cols="40" class="k-textbox textbox-custom" id="txt_suggestedVendor" name="txt_suggestedVendor" readonly><?php echo $view['suggested_vendor'];?></textarea>
													</td>

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

													<td >Purpose</td>
													<td>:</td>
													<td>
														<textarea rows="2" cols="40" class="k-textbox textbox-custom" id="txt_purpose" name="txt_purpose" readonly><?php echo $view['purpose'];?></textarea>
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
														<input class="k-textbox textbox-custom" id="txt_CostCenter" name="txt_CostCenter" value="<?php echo $view['cost_center'];?>" readonly/>
													</td>
													
													<td>MR No.</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_NoMR" name="txt_NoMR" value="<?php echo $view['mr_no'];?>" readonly/>
													</td>

													<td>PR No.</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_NoPR" name="txt_NoPR" value="<?php echo $view['pr_no'];?>" placeholder="Generate by Purchasing" readonly/>
													</td>
												</tr>
											</table>		

												<?php
													function date_convert($date) {
														$newDateString = date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
														return $newDateString;
													}
													$query = pg_query($conn, "SELECT * FROM vw_t_document_history WHERE header_id = {$header_id} and modified_by_app = '$nik' ");
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
										<a href="view_report.php" class="btn btn-danger btn-xs"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; Back</a>
										<button id="add_data" name="add_data" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-th-list"></i> &nbsp; View History Document</button>
										<!-- <input type="button"  class="btn btn-info" value="Print" onclick="PrintDoc()" /> -->						
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
							<?php
								function date_convert2($date) {
									$newDateString = date_format(date_create_from_format('Y-m-d h:m:s', $date), 'd-m-Y h:m:s');
									return $newDateString;
								}
								echo '
								<div class="table-header">
									
								</div>
								<div class="box-body table-responsive">
									<table id="dynamic-tableHis" class="table table-bordered table-hover " cellspacing="0" width="100%">
										<thead>
											<tr>		
												<th>NO</th>
												<th>ID DOCUMENT</th>
												<th>STATUS</th>
												<th>REMARKS</th>
												<th>ACTION DATE</th>
												<th>ACTION BY</th>
											</tr>
										</thead>
										<tbody>';
											$no = 1;
											$query = pg_query($conn, "SELECT header_id, status_doc, status_desc, remarks, modified_date, modified_by FROM public.tbl_t_document_history WHERE header_id = {$header_id} order by modified_date desc ");
											while ($result = pg_fetch_array($query)){ echo' 
												<tr>	
													<td><center><span class="badge badge-info">'.$no.'</span></td>																		
													<td>'.$result['header_id'].'</td>
													<td>'.$result['status_desc'].'</td>
													<td>'.$result['remarks'].'</td>
													<td>'.$result['modified_date'].'</td>																										
													<td>'.$result['modified_by'].'</td>													
												</tr>';
											$no++;
											} 																
										echo'</tbody>
									</table>
								</div><br/>';
							?>
							<button type="button" id="cancel" name="cancel" class="btn btn-primary btn-xs" onclick="cancel()"><span class="glyphicon glyphicon-remove"></span>&nbsp; Close</button>				
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
			
			// Get the modal
			var modal = document.getElementById('myModal');
			var myModalItemCode = document.getElementById('myModalItemCode');
			
			// Get the button that opens the modal
			var btn = document.getElementById("add_data");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			var spanitem = document.getElementsByClassName("spanitem")[0];
			
			// When the user clicks the button, open the modal 
			btn.onclick = function() {				
				modal.style.display = "block";
			}

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modal.style.display = "none";
			}
			
			spanitem.onclick = function() {
				myModalItemCode.style.display = "none";
			}
				
			function cancel() {
				modal.style.display = "none";							
			}
			
		</script>
	</body>
</html>

