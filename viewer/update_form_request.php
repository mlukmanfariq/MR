<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
			
	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');
	$noPR = "Generate By Purchasing";
	
	$dept_id = $_SESSION['department'];
	$departemen_name = $_SESSION['department'];
	
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
							User (Purchasing)
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
									$preparer_id = $result['id_user'];
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
						<a href="sync.php?last_step_dokumen=0">
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
								<i class="ace-icon fa fa-stack-exchange"></i>
								<a href="index.php">Home</a>
							</li>
							<li class="active">Approval Form Requisition</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								Approval Form Requisition
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
													$query = pg_query($conn, "SELECT * FROM vw_t_approvaldocument WHERE header_id = {$header_id} and nik_approval = 'pur' ");
													$view = pg_fetch_array($query);
																											
												?>
												<input type="hidden" id="headerid" name="headerid" value="<?php echo $header_id;?>" readonly/>
												<input type="hidden" id="deptid" name="deptid" value="<?php echo $dept_id;?>" readonly/>
												<input type="hidden" id="user" name="user" value="<?php echo $user;?>" readonly/>
												<input type="hidden" id="datetime" name="datetime" value="<?php echo $datetime;?>" readonly/>
												<input type="hidden" id="created_deptID" name="created_deptID" value="<?php echo $departmentid;?>" readonly/>
												<input type="hidden" id="preparer_id" name="preparer_id" value="<?php echo $preparer_id;?>" readonly/>
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
															<button type="button" id="searchRequestor" name ="searchRequestor" class="btn btn-xs" onclick="searchRequestor()" readonly><span class="glyphicon glyphicon-search"></span></button>&nbsp; &nbsp; 
														</td>
													</tr>
													<tr>
														<td>Department</td>
														<td>:</td>
														<td>
															<input class="k-textbox textbox-custom" id="txt_Department" name="txt_Department" value="<?php echo $view['user_department'];?>" readonly/>
														</td>

														<td >MR Desc.</td>
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
													$cek = pg_query($conn, "SELECT * FROM tbl_t_request_detail where header_id = {$header_id} and created_by = '{$created_by}' ");
													$cek_row = pg_num_rows($cek);
													echo '
													<div class="table-header">
														Table List Item
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
																	<th class="nosort"><center>Action</th>
																</tr>
															</thead>
															<tbody>';
																if($cek_row > 0){
																	$no = 1;
																	$query = pg_query($conn, "SELECT * FROM vw_t_requestall where header_id = {$header_id}  and created_by = '{$created_by}' ORDER BY row_detail_id");
																	while ($result = pg_fetch_array($query)){ 
																		echo' 
																		<tr>	
																			<td><center><span class="badge badge-info">'.$no.'</span></td>																		
																			<td>'.$result['item_no'].'</td>
																			<td>'.str_replace("*", "'", $result['desc_material']).'</td>
																			<td>'.$result['req_qty'].'</td>
																			<td>'.$result['uom'].'</td>
																			<td>'.date_convert($result['last_order_date']).'</td>
																			<td>'.$result['last_order_qty'].'</td>
																			<td>'.$result['min_stock'].'</td>
																			<td>'.$result['max_stock'].'</td>
																			<td>'.$result['stock_bal'].'</td>
																			<td>'.date_convert($result['needed_date']).'</td>
																			<td><center>
																				<button type="button" class="btn btn-success btn-minier" onclick="editRow()" title="Edit"><i class="fa fa-keyboard-o "></i></button>																				
																			</td>
																			<td style="display:none;">'.$result['category_id'].'</td>
																			<td style="display:none;">'.$result['organization_id'].'</td>
																			<td style="display:none;">'.$result['destination_type_code'].'</td>
																			<td style="display:none;">'.$result['rowid'].'</td>
																		</tr>';
																	$no++;
																	} 
																}else {
																	echo '<td colspan=12 class="huge"><center>No Data Row</td>';
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
									<button id="approve_data" name="approve_data"  class="btn btn-success btn-xs" onclick="approve()"><i class="glyphicon glyphicon-ok"></i> &nbsp; Save and Approve</button>
									<button id="reject_data" name="reject_data" class="btn btn-danger btn-xs" onclick="reject()"><i class="glyphicon glyphicon-remove"></i> &nbsp; Reject</button>		
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
								<input type = "hidden" class="k-textbox textbox-custom" id="txt_CATEGORY_ID" name="txt_CATEGORY_ID"/>
								<input type = "hidden" class="k-textbox textbox-custom" id="txt_ORGANIZATION_ID" name="txt_ORGANIZATION_ID"/>
								<input type = "hidden" class="k-textbox textbox-custom" id="txt_DESTINATION_TYPE_CODE" name="txt_DESTINATION_TYPE_CODE"/>
								<input type = "hidden" class="k-textbox textbox-custom" id="txt_DescriptionItem" name="txt_DescriptionItem"/>
								<input type = "hidden" class="k-textbox textbox-custom" id="txt_rowid" name="txt_rowid"/>
								&nbsp; &nbsp;
								<table cellpadding="6" class="table table-bordered">
									<tr>
										<td>Item No</td>
										<td>:</td>
										<td>
											<input class="k-textbox textbox-custom" id="txt_itemNo" name="txt_itemNo" placeholder="Searching Description"/>
											<button type="button" id="search" name ="search" class="btn btn-danger btn-minier" onclick="search()"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;Check Item</button> 
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
										<td >
											<input class="k-textbox textbox-custom" id="txt_Description" name="txt_Description"/>																						
										</td>
										
										<td>Reqt Qty.</td>
										<td>:</td>
										<td>
											<input type="number" class="k-textbox textbox-custom" id="txt_ReqtQty" name="txt_ReqtQty"/>
										</td>
									</tr>
									<tr>
										<td>Needed by Date</td>
										<td>:</td>
										<td>
											<input type="date" id="txt_neededDate" name="txt_neededDate" class="k-textbox textbox-custom" value="<?php echo $date;?>"/>
											<span class="error"><?php echo $error_date?></span>
										</td>
										
										<td>Last Order Date</td>
										<td>:</td>
										<td>
											<input type="date" id="txt_lastOrderdate" name="txt_lastOrderdate" class="k-textbox textbox-custom" value="<?php echo $date;?>" size="40"/>
											<span class="error"><?php echo $error_date?></span>
										</td>																				
									</tr>
									<tr>																		
										<td>Last Order Qty</td>
										<td>:</td>
										<td>
											<input type="number" class="k-textbox textbox-custom" id="txt_lastOrderQty" name="txt_lastOrderQty"/>
										</td>
										
										<td>Stock Bal.</td>
										<td>:</td>
										<td>
											<input type="number" id="txt_stockBal" name="txt_stockBal" class="k-textbox textbox-custom"/>
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

									</br>
								</table>
								</br>
								&nbsp; &nbsp; 
								<button type="button" id="adddata" name ="adddata" class="btn btn-success btn-xs" onclick="addRow()"><span class="glyphicon glyphicon-saved"></span>&nbsp; Update Row</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning btn-xs" onclick="cancel()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>																							
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
								&nbsp; &nbsp; &nbsp;<button type="button" id="approve_row" name ="approve_row" class="btn btn-success btn-xs" onclick="approveRow()"><span class="glyphicon glyphicon-ok"></span>&nbsp; Approve</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning btn-xs" onclick="cancelAppr()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>	
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
								&nbsp; &nbsp; &nbsp;<button type="button" id="reject_row" name ="reject_row" class="btn btn-danger btn-xs" onclick="rejectRow()"><span class="glyphicon glyphicon-remove"></span>&nbsp; Reject</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning btn-xs" onclick="cancelAppr()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>	
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
								<button type="button" id="cancel" name="cancel" class="btn btn-danger btn-xs" onclick="cancelItem()"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Close</button>	
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
			
			function approve(){
				cekAllRow();			
			}
			
			function reject(){
				$("#txt_remarksReject").val("");	
				modalReject.style.display = "block";
			}
			
			function cekAllRow() {
				var txt_headerid = $("#headerid").val();
				var pendingItem = 0;
				var dataString = 'headerid='+ txt_headerid;
				console.log(dataString);
				$.ajax({
					type: 'POST',
					url: 'Controllers/cekItemCode.php',
					//data: {'myData':dataString},
					data: dataString,
					cache: false,
					success: function (result) {
						pendingItem = result;
						if (pendingItem == 0) {
							$("#txt_remarksApprove").val("");	
							modalApp.style.display = "block";
						} else {
							if (confirm(pendingItem + ' row(s) Item Code still Empty. Are you sure to exit this document?')) 
							{
								window.location.href = "index.php";						
							} else {
								// Do nothing!
							}	
						}
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});	
			}
			
			function approveRow(){
				var txt_option			= "approve";
				var txt_status_doc		= "1";
				var txt_status_desc		= "Approve by Purchasing";
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
							saveToInterface();							
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
			
			function saveToInterface(){
				var txt_headerid 	= $("#headerid").val();
				var txt_preparer_id = $("#preparer_id").val();
				var dataString = 'headerid='+ txt_headerid + '&preparer_id=' + txt_preparer_id;
				console.log(dataString);
				$.ajax({
					type: 'POST',
					url: 'Controllers/saveinterface.php',
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
			
			function rejectRow(){
				var txt_option			= "reject";
				var txt_status_doc		= "0";
				var txt_status_desc		= "Reject by Purchasing";
				var txt_remarks			= $("#txt_remarksReject").val();
				var txt_modified_date	= $("#datetime").val();
				var txt_modified_by		= $("#user").val();
				var txt_headerid		= $("#headerid").val();
				
				if (txt_remarks != ""){ 
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
			
			function cancelAppr() {
				modalApp.style.display = "none";
				modalReject.style.display = "none";
				$("#txt_remarksApprove").val("");			
				$("#txt_remarksReject").val("");
			}
			
			function search(){				
				$.ajax({
					type: 'GET',
					url: 'Controllers/uom_table.php',
					data: {
						description1: $("#txt_itemNo").val()
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
			
			function selectItem(){
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
					var txt_itemNo = document.getElementById('txt_itemNo');
					var txt_UOM = document.getElementById('txt_UOM');
					var txt_CATEGORY_ID = document.getElementById('txt_CATEGORY_ID');
					var txt_ORGANIZATION_ID = document.getElementById('txt_ORGANIZATION_ID');
					var txt_DESTINATION_TYPE_CODE = document.getElementById('txt_DESTINATION_TYPE_CODE');
					var txt_DescriptionItem = document.getElementById('txt_DescriptionItem');
					var txt_Description = document.getElementById('txt_Description');
					var replaceDesc = cells[3].innerHTML;

					txt_itemNo.value = cells[1].innerHTML;
					txt_UOM.value = cells[2].innerHTML;
					txt_DescriptionItem.value = replaceDesc;
					txt_Description.value = replaceDesc;
					txt_CATEGORY_ID.value = cells[4].innerHTML;
					txt_ORGANIZATION_ID.value = cells[5].innerHTML;
					txt_DESTINATION_TYPE_CODE.value = cells[6].innerHTML;
					//console.log(target.nodeName, event);
				};
				myModalItemCode.style.display = "none";
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
						deptid: $("#txt_Requestor").val()
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
						
			function cancel() {
				modal.style.display = "none";												
			}
						
			function addRow(){

				var txt_itemNo			= $("#txt_itemNo").val();
				var txt_Description		= $("#txt_Description").val().replace("'", "*");
				var txt_ReqtQty 		= $("#txt_ReqtQty").val();
				var txt_UOM				= $("#txt_UOM").val();
				var txt_neededDate		= $("#txt_neededDate").val();
				var txt_lastOrderQty	= $("#txt_lastOrderQty").val();
				var txt_lastOrderdate 	= $("#txt_lastOrderdate").val();
				var txt_minStock		= $("#txt_minStock").val();
				var txt_maxStock		= $("#txt_maxStock").val();
				var txt_stockBal		= $("#txt_stockBal").val();
				//var txt_Purpose			= $("#txt_Purpose").val();
				var txt_user			= $("#user").val();
				var txt_date			= $("#txt_date").val();
				var txt_headerid		= $("#headerid").val();
				var txt_rowid			= $("#txt_rowid").val();
				var txt_CATEGORY_ID		= $("#txt_CATEGORY_ID").val();
				var txt_ORGANIZATION_ID	= $("#txt_ORGANIZATION_ID").val();
				var txt_DESTINATION_TYPE_CODE		= $("#txt_DESTINATION_TYPE_CODE").val();

				//var dataString = JSON.stringify(postData);
				var dataString = 'itemNo='+ txt_itemNo + '&description='+ txt_Description + '&reqtQty='+ txt_ReqtQty + '&uom='+ txt_UOM 
								+ '&needed_date='+ txt_neededDate  + '&lastOrderQty='+ txt_lastOrderQty  + '&lastOrderdate='+ txt_lastOrderdate  
								+ '&minStock='+ txt_minStock  + '&maxStock='+ txt_maxStock  + '&stockBal='+ txt_stockBal
								+ '&create_by='+ txt_user  + '&created_date='+ txt_date + '&headerid='+ txt_headerid
								+ '&rowid='+ txt_rowid  + '&category_id='+ txt_CATEGORY_ID  + '&organization_id='+ txt_ORGANIZATION_ID + '&destination_type_code='+ txt_DESTINATION_TYPE_CODE;
				console.log(dataString);
				$.ajax({
					type: 'POST',
					url: 'Controllers/updaterow.php',
					//data: {'myData':dataString},
					data: dataString,
					cache: false,
					success: function (result) {
						alert(result);
						modal.style.display = "none";
						window.location.href = "update_form_request.php?header_id=" + txt_headerid;
						
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});				
			}
			
			function editRow(){
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
					
					txt_itemNo.value = cells[1].innerHTML.trim();
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

