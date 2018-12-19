<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		
	$query = pg_query($conn, "select nextval('next_header') as header_id");
	$nextid = pg_fetch_array($query);
	$header_id = $nextid['header_id'];
	$_SESSION['nextid'] = $header_id;
	
	$query = pg_query($conn, "select nextval('next_mr_no') as next_mr_no");
	$nextid = pg_fetch_array($query);
	$next_mr_no = $nextid['next_mr_no'];
	
	if ($next_mr_no < 10) {
		$mr_no = date("Y") . '000' . $next_mr_no;
	} else if (($next_mr_no >= 10) && ($next_mr_no < 100)) {
		$mr_no = date("Y") . '00' . $next_mr_no;
	}  else if (($next_mr_no >= 100) && ($next_mr_no < 999)) {
		$mr_no = date("Y") . '0' . $next_mr_no;
	} else {
		$mr_no = date("Y") . $next_mr_no;
	}
	
	$dept_id = $_SESSION['department'];
	$query = pg_query($conn, "select * from tbl_r_departemen where departemen_id = $dept_id ");
	$dept_query = pg_fetch_array($query);
	$departemen_name = $dept_query['departemen_name'];
		
	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');
	$noPR = "Generate By Purchasing";
	$itemNo = "Searching Description";
	
	$user = pg_escape_string($_SESSION['user']);
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
					<li class="">
						<a href="index.php">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Home</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="active">
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
								<i class="ace-icon fa fa-stack-exchange"></i>
								<a href="#">Form Material Requisition </a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								Form Material Requisition
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<div class="panel panel-primary">
									<div class="panel-heading">Purchase Requisition Application Form</div>
									<!--<form class="form-horizontal style-form" action="" method="get"> -->
										<div class="panel-body">
											<div class="form-group">
												<input type="hidden" id="headerid" name="headerid" value="<?php echo $header_id;?>" readonly/>
												<input type="hidden" id="deptid" name="deptid" value="<?php echo $dept_id;?>" readonly/>
												<input type="hidden" id="user" name="user" value="<?php echo $user;?>" readonly/>
												<input type="hidden" id="datetime" name="datetime" value="<?php echo $datetime;?>" readonly/>
												<table cellpadding="6" class="table table-bordered">
													<tr>
														<td>Section</td>
														<td>:</td>
														<td>
															<input class="k-textbox textbox-custom" id="txt_section" name="txt_section"/>
														</td>

														<td colspan="3">Suggested Vendor :</td>

														<td>Requestor</td>
														<td>:</td>
														<td>
															<input class="k-textbox textbox-custom" id="txt_Requestor" name="txt_Requestor" placeholder="Click Search Button" readonly/>
															<button type="button" id="searchRequestor" name ="searchRequestor" class="btn btn-xs" onclick="searchRequestor()"><span class="glyphicon glyphicon-search"></span></button>&nbsp; &nbsp; 
														</td>
													</tr>
													<tr>
														<td>Department</td>
														<td>:</td>
														<td>
															<input class="k-textbox textbox-custom" id="txt_Department" name="txt_Department" value="<?php echo $departemen_name;?>" readonly/>
														</td>

														<td colspan="3">
															<textarea rows="3" cols="40" class="k-textbox textbox-custom" id="txt_suggestedVendor" name="txt_suggestedVendor"></textarea>
														</td>
														
														<td>Date</td>
														<td>:</td>
														<td>
															<input type="date" id="txt_date" name="txt_date" class="k-textbox textbox-custom" value="<?php echo $date;?>" readonly/>
															<span class="error"><?php echo $error_date?></span>
														</td>
													</tr>
													<tr>
														<td>Cost Center</td>
														<td>:</td>
														<td>
															<input class="k-textbox textbox-custom" id="txt_CostCenter" name="txt_CostCenter"/>
														</td>
														
														<td>MR No.</td>
														<td>:</td>
														<td>
															<input class="k-textbox textbox-custom" id="txt_NoMR" name="txt_NoMR" value="<?php echo $mr_no;?>" readonly/>
														</td>

														<td>PR No.</td>
														<td>:</td>
														<td>
															<input class="k-textbox textbox-custom" id="txt_NoPR" name="txt_NoPR" value="" placeholder="Generate by Purchasing" readonly/>
														</td>
													</tr>
												</table>		
																								
												<?php
													function date_convert($date) {
														$newDateString = date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
														return $newDateString;
													}													
													echo '
													<div class="table-header">
														<div class="panel-heading"><button id="add_data" name="add_data" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-plus"></i>Add Records</button></div>
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
																	<th class="nosort"><center>Action</th>
																</tr>
															</thead>
															<tbody>';
																$no = 1;
																$query = pg_query($conn, "SELECT * FROM vw_t_requestall where header_id = {$header_id}");
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
																		<td><center>
																			<a class="btn btn-danger-sm" name="delete" href="Controllers/delete_software.php?id='.$result['id_software'].'"> <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o "></i></button></a>
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
									<!--</form> -->
										&nbsp; &nbsp; &nbsp;
										<button name="clear" class="btn btn-default" onclick="cancelInsert()">Clear</button>								
										<button type="submit" id="submitDraft" name ="save" class="btn btn-warning" onclick="submitDraft()">Save as Draft</button>
										<button type="submit" id="submit" name ="save" class="btn btn-success" onclick="submitDeptHead()">Send to Dept Head</button>
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
							<div class="panel-heading">Purchase Requisition Detail</div>
								&nbsp; &nbsp;
								<table cellpadding="6" class="table table-bordered">
									<tr>
										<td>Item No</td>
										<td>:</td>
										<td>
											<input class="k-textbox textbox-custom" id="txt_itemNo" name="txt_itemNo" placeholder="Searching Description"/>
										</td>

										<td>UOM</td>
										<td>:</td>
										<td>
											<input class="k-textbox textbox-custom" id="txt_UOM" name="txt_UOM" placeholder="Searching Description"/>
										</td>
									</tr>
									<tr>
										<td>Description of Material</td>
										<td>:</td>
										<td colspan="4">
											<input class="k-textbox textbox-custom" id="txt_Description" name="txt_Description" style="height:40px;width:720px;"/>											
											<button type="button" id="search" name ="search" class="btn btn-default btn-sm" onclick="search()"><span class="glyphicon glyphicon-search"></span></button>&nbsp; &nbsp; 
										</td>
									</tr>
									<tr>
										<td>Reqt Qty.</td>
										<td>:</td>
										<td>
											<input type="number" class="k-textbox textbox-custom" id="txt_ReqtQty" name="txt_ReqtQty"/>
										</td>
										
										<td>Needed by Date</td>
										<td>:</td>
										<td>
											<input type="date" id="txt_neededDate" name="txt_neededDate" class="k-textbox textbox-custom" value="<?php echo $date;?>"/>
											<span class="error"><?php echo $error_date?></span>
										</td>																			
									</tr>
									<tr>
										<td>Last Order Date</td>
										<td>:</td>
										<td>
											<input type="date" id="txt_lastOrderdate" name="txt_lastOrderdate" class="k-textbox textbox-custom" value="<?php echo $date;?>" size="40"/>
											<span class="error"><?php echo $error_date?></span>
										</td>	
										
										<td>Last Order Qty</td>
										<td>:</td>
										<td>
											<input type="number" class="k-textbox textbox-custom" id="txt_lastOrderQty" name="txt_lastOrderQty"/>
										</td>
									</tr>

									<tr>
										<td>Min. Stock</td>
										<td>:</td>
										<td>
											<input type="number" id="txt_minStock" name="txt_minStock" class="k-textbox textbox-custom"/>
										</td>

										<td>Max. Stock</td>
										<td>:</td>
										<td>
											<input type="number" id="txt_maxStock" name="txt_maxStock" class="k-textbox textbox-custom"/>
										</td>
									</tr>
									
									<tr>								
										<td>Stock Bal.</td>
										<td>:</td>
										<td>
											<input type="number" id="txt_stockBal" name="txt_stockBal" class="k-textbox textbox-custom"/>
										</td>
										
										<td>Purpose</td>
										<td>:</td>
										<td>
											<input id="txt_Purpose" name="txt_Purpose" class="k-textbox textbox-custom"/>
										</td>
									</tr>
									</br>
								</table>
								</br>
								&nbsp; &nbsp; 
								<button type="button" id="adddata" name ="adddata" class="btn btn-success" onclick="header()"><span class="glyphicon glyphicon-saved"></span>&nbsp; Add Row</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning" onclick="cancel()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>																							
						</div>
					  </div>
					
					</div>
					
					<!-- The Modal -->
					<div id="myModalItemCode" class="modal">
					  <!-- Modal content -->
						<div class="modal-content">
							<div class="panel panel-primary">
								<div class="row" id="uom_table">
									
								</div>
								</br>
								<button type="button" id="cancel" name="cancel" class="btn btn-danger" onclick="cancelItem()"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Close</button>	
							</div>
						</div>
					
					</div>
					
					<!-- The Modal -->
					<div id="myModalRequestor" class="modal">
					  <!-- Modal content -->
						<div class="modal-content">
							<div class="panel panel-primary">							
								<div class="row" id="requestor_table">
									
								</div>
								</br>
								<button type="button" id="cancel" name="cancel" class="btn btn-danger" onclick="cancelRequestor()"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Close</button>	
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
			var modal = document.getElementById('myModal');
			var myModalItemCode = document.getElementById('myModalItemCode');
			
			// Get the button that opens the modal
			var btn = document.getElementById("add_data");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			var spanitem = document.getElementsByClassName("spanitem")[0];
			
			// When the user clicks the button, open the modal 
			btn.onclick = function() {
				initialize();
				modal.style.display = "block";
			}

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modal.style.display = "none";
				initialize()
			}
			
			spanitem.onclick = function() {
				myModalItemCode.style.display = "none";
				initialize()
			}
			
			function search(){				
				$.ajax({
					type: 'GET',
					url: 'Controllers/uom_table.php',
					data: {
						description1: $("#txt_Description").val()
					},
					cache: false,
					success: function (result) {
						$("#uom_table").html(result);		
						myModalItemCode.style.display = "block";
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});	
			}
			
			function cancelItem(){
				myModalItemCode.style.display = "none";
			}
			
			function searchRequestor(){
				var myModalRequestor = document.getElementById('myModalRequestor');
				$.ajax({
					type: 'GET',
					url: 'Controllers/requestor_table.php',
					data: {
						deptid: $("#deptid").val()
					},
					cache: false,
					success: function (result) {
						$("#requestor_table").html(result);		
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
				var table_id = document.getElementById('dynamic-table');

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
					var txt_Requestor = document.getElementById('txt_Requestor');
					txt_Requestor.value = cells[1].innerHTML + '--' + cells[3].innerHTML;
					//console.log(target.nodeName, event);
				};
				myModalRequestor.style.display = "none";
			}	
						
			function cancel() {
				modal.style.display = "none";				
				initialize()				
			}
			
			function header(){

				var txt_section			= $("#txt_section").val();
				var txt_Department		= $("#txt_Department").val();
				var txt_Requestor 		= $("#txt_Requestor").val();
				var split_Requestor		= txt_Requestor.split('--');
				var RequestorID			= split_Requestor[0];
				var txt_CostCenter		= $("#txt_CostCenter").val();
				var txt_suggestedVendor	= $("#txt_suggestedVendor").val();
				var txt_NoPR 			= $("#txt_NoPR").val();
				var txt_user			= $("#user").val();
				var txt_NoMR			= $("#txt_NoMR").val();
				var txt_date			= $("#txt_date").val();
				var txt_headerid		= $("#headerid").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'user_section='+ txt_section + '&user_department='+ txt_Department + '&requestor_id='+ RequestorID + '&cost_center='+ txt_CostCenter 
								+ '&suggested_vendor='+ txt_suggestedVendor  + '&pr_no='+ txt_NoPR  + '&create_by='+ txt_user  
								+ '&mr_no='+ txt_NoMR  + '&created_date='+ txt_date + '&headerid='+ txt_headerid;
				console.log(dataString);
				
				if ((txt_Requestor != "")){
					$.ajax({
					type: 'POST',
					url: 'Controllers/addheader.php',
					//data: {'myData':dataString},
					data: dataString,
					cache: false,
					success: function (result) {
						console.log(result);
						addRow();
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});
				} else {
					alert("Field Requestor is Empty!!!");
				}
			}
			
			function addRow(){

				var txt_itemNo			= $("#txt_itemNo").val();
				var txt_Description		= $("#txt_Description").val();
				var txt_ReqtQty 		= $("#txt_ReqtQty").val();
				var txt_UOM				= $("#txt_UOM").val();
				var txt_neededDate		= $("#txt_neededDate").val();
				var txt_lastOrderQty	= $("#txt_lastOrderQty").val();
				var txt_lastOrderdate 	= $("#txt_lastOrderdate").val();
				var txt_minStock		= $("#txt_minStock").val();
				var txt_maxStock		= $("#txt_maxStock").val();
				var txt_stockBal		= $("#txt_stockBal").val();
				var txt_Purpose			= $("#txt_Purpose").val();
				var txt_user			= $("#user").val();
				var txt_date			= $("#txt_date").val();
				var txt_headerid		= $("#headerid").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'itemNo='+ txt_itemNo + '&description='+ txt_Description + '&reqtQty='+ txt_ReqtQty + '&uom='+ txt_UOM 
								+ '&needed_date='+ txt_neededDate  + '&lastOrderQty='+ txt_lastOrderQty  + '&lastOrderdate='+ txt_lastOrderdate  
								+ '&minStock='+ txt_minStock  + '&maxStock='+ txt_maxStock  + '&stockBal='+ txt_stockBal + '&purpose='+ txt_Purpose 
								+ '&create_by='+ txt_user  + '&created_date='+ txt_date + '&headerid='+ txt_headerid;
				console.log(dataString);
				$.ajax({
					type: 'POST',
					url: 'Controllers/addrow.php',
					//data: {'myData':dataString},
					data: dataString,
					cache: false,
					success: function (result) {
						alert(result);
						initialize();
						modal.style.display = "none";
						window.location.href = "update_form_request.php?header_id=" + txt_headerid;
						
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});				
			}

			function initialize() {
				$("#txt_itemNo").val("");
				$("#txt_Description").val("");
				$("#txt_ReqtQty").val("0");
				$("#txt_UOM").val("");
				$("#txt_lastOrderQty").val("0");
				$("#txt_minStock").val("0");
				$("#txt_maxStock").val("0");
				$("#txt_stockBal").val("0");
				$("#txt_Purpose").val("");
			}
				
			function PrintDoc() {
				var toPrint = document.getElementById('print');
				var popupWin = window.open('', '_blank', 'width=800,height=500,location=no,left=200px');
				popupWin.document.open();
				popupWin.document.write('<html><title>::Preview::</title><link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" /></head><body onload="window.print()">')
				popupWin.document.write(toPrint.innerHTML);
				popupWin.document.write('</html>');
				popupWin.document.close();
			}
					
			function cancelInsert(){
				var txt_option		= "cancel";
				var txt_headerid	= $("#headerid").val();
				var txt_status_doc		= "101";
				var txt_status_desc		= "Send by User";
				var txt_remarks			= "Send by User";
				var txt_modified_date	= $("#datetime").val();
				var txt_modified_by		= $("#user").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'option='+ txt_option + '&status_doc='+ txt_status_doc + '&status_desc='+ txt_status_desc + '&remarks='+ txt_remarks + '&modified_date='+ txt_modified_date 
									+ '&modified_by='+ txt_modified_by + '&headerid='+ txt_headerid;
				console.log(dataString);
				if (confirm('Are you sure you want to save this thing into the database?')) {
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
					// Do nothing!
				}							
			}
			
			function submitDraft(){
				var txt_option		= "draft";
				var txt_headerid	= $("#headerid").val();
				var txt_status_doc		= "0";
				var txt_status_desc		= "Send by User";
				var txt_remarks			= "Send by User";
				var txt_modified_date	= $("#datetime").val();
				var txt_modified_by		= $("#user").val();
				
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
			}
			
			function submitDeptHead(){
				var txt_option			= "send";
				var txt_headerid		= $("#headerid").val();
				var txt_status_doc		= "1";
				var txt_status_desc		= "Send by User";
				var txt_remarks			= "Send by User";
				var txt_modified_date	= $("#datetime").val();
				var txt_modified_by		= $("#user").val();
				
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
			}
		</script>
	</body>
</html>

