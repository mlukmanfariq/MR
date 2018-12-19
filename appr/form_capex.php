<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		
	$query = pg_query($conn, "select nextval('next_header') as header_id");
	$nextid = pg_fetch_array($query);
	$header_id = $nextid['header_id'];
	$_SESSION['nextid'] = $header_id;
	
	$dept_id = $_SESSION['department'];
	$departemen_name = $_SESSION['department'];
		
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
				padding: 2px 10px;
				background-color: #337ab7;
				color: white;
				font-size: 20px;
			}

			.modal-body {padding: 2px 16px;}

			.modal-footer {
				padding: 2px 16px;
				/*background-color: #5cb85c;*/
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
							User (Preparer)
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
					<li class="">
						<a href="form_request.php">
							<i class="menu-icon fa fa-stack-exchange"></i>
							<span class="menu-text"> Form Request</span>
						</a>
						<b class="arrow"></b>
					</li>
					<?php if (($_SESSION['user_depthead']) && ($_SESSION['department'] == 'Finance')){?>
					<li class="">
						<a href="form_capex.php">
							<i class="menu-icon fa fa-stack-exchange"></i>
							<span class="menu-text"> CAPEX</span>
						</a>
						<b class="arrow"></b>
					</li>
					<?php }?>
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
								<i class="ace-icon fa fa-stack-exchange"></i>
								<a href="#">Capex </a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
						<div class="page-header">
							<h1>
								View Capex Master
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">	
								<a id="add_data" name="add_data" class="btn btn-block btn-lg btn-info add">
									<i class="fa fa-plus-circle"></i> Add Capex Master Data
								</a>
								<hr />	
								<?php
									function date_convert($date) {
										$newDateString = date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
										return $newDateString;
									}													
									echo '
									<div class="table-header">
										Table Capex 
									</div>
									<div class="box-body table-responsive">
										<table id="dynamic-table_detail" class="table table-bordered table-hover " cellspacing="0" width="100%">
											<thead>
												<tr>		
													<th>NO</th>
													<th>DEPARTMENT</th>
													<th>CAPEX NUMBER</th>
													<th>DESCRIPTION</th>
													<th>YEAR</th>
													<th>AMOUNT</th>
													<th class="nosort"><center>Action</th>
												</tr>
											</thead>
											<tbody>';
												$no = 1;
												$query = pg_query($conn, "SELECT * FROM tbl_r_capex_dept cd JOIN tbl_r_departemen d ON cd.departemen_id = d.departemen_id");
												while ($result = pg_fetch_array($query)){ echo' 
													<tr>	
														<td><center><span class="badge badge-info">'.$no.'</span></td>	
														<td>'.$result['departemen_name'].'</td>		
														<td>'.$result['capex_number'].'</td>
														<td>'.$result['capex_desc'].'</td>
														<td>'.$result['capex_year'].'</td>
														<td>'.$result['amount'].'</td>
														<td><center><button type="button" id="'.$result['departemen_id'].'_'.$result['capex_number'].'" name ="edit_capex" class="capex btn btn-success btn-xs" ><span class="glyphicon glyphicon-saved"></span> Edit Capex</button> </td>
													</tr>';
													$no++;
													}echo'
											</tbody>
										</table>
									</div><br/>';
								?>
			
							</div>
						</div>
						<!-- The Modal -->
						<div id="myModal" class="modal">
						 	<!-- Modal content -->
						  	<div class="modal-content">
								<span class="close">&times;</span>
								<div class="modal-header">Capex Master Form</div>
								<div class="modal-body">
									<div class="form-horizontal style-form"><br>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label ">Department</label>
											<div class="col-sm-3">
												<!-- <input type="text" id="dept" class="form-control" name="id_dept" value="<?php echo $departemen_name?>" readonly/> -->
												<select class="form-control"  name="id_dept" id="id_dept">
													<option value=""> -- Select Department -- </option>
													<?php 
														
														$sql =  pg_query($conn, "SELECT * FROM tbl_r_departemen");
														while($row = pg_fetch_array($sql)){
																echo "<option value=\"{$row['departemen_id']}\">{$row['departemen_name']}</option>",PHP_EOL;
														}
													?>
												</select>
											</div>
											<label class="col-sm-3 col-sm-3 control-label ">Capex Number</label>
											<div class="col-sm-2">
												<input type="text" id="capex_number" class="form-control" name="capex_number"/>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label ">Capex Description</label>
											<div class="col-sm-4">
												<textarea id="capex_desc" name="capex_desc" class="form-control" class="form-control" rows="3" cols="10"></textarea>
											</div>
											<label class="col-sm-2 col-sm-2 control-label ">Capex Year</label>
											<div class="col-sm-1">
												<input id="capex_year" type="number" class="form-control" name="capex_year"/>
											</div>
											<label class="col-sm-1 col-sm-1 control-label ">Amount</label>
											<div class="col-sm-2">
												<input id="amount" type="number" class="form-control" name="Amount"/>
											</div>
										</div>	
									</div>
								</div>
								<div class="modal-footer"><center> 
									<button type="button" id="btn_capex" name ="add_data" class="btn btn-success btn" onclick="add_capex()"><span class="glyphicon glyphicon-saved"></span> Add Data</button> 
									<button type="button" id="cancel" name="cancel" class="btn btn-warning btn" onclick="cancel()"><span class="glyphicon glyphicon-retweet"></span> Cancel</button>		
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
				$("#capex_year").attr("maxlength", 4);
				$("#capex_number").attr("maxlength", 30);
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
						{ type: "select" },
						null,
						{ type: "select" },
						null,
						null,
						null
					]
				});
				
				$("#success-alert").alert();
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").slideUp(500);
				});
				
			});
			
			// Get the modal
			var modal = document.getElementById('myModal');

			// Get the button that opens the modal
			var btn = document.getElementById("add_data");
			
			
			// When the user clicks the button, open the modal 
			btn.onclick = function() {
				initialize();
				modal.style.display = "block";
				//lkm
				document.getElementById("id_dept").disabled = false;
                document.getElementById("capex_number").disabled = false;
               	$("#btn_capex").val('add');
               	document.getElementById("btn_capex").textContent = 'Add Data';
			}

			//get dept, capex
			//lkm
			$('.capex').click(function(){
				var btn_id =  $(this).attr('id'); //getting the btn's id
				var str_id = btn_id.trim();
				var res = str_id.split("_");
				getInfoCapex(res);
				$("#btn_capex").val('update');
				document.getElementById("btn_capex").textContent = 'Update Data';
				modal.style.display = "block";
			});	
			//get info capex
			//lkm
			function getInfoCapex(id){
				var dataString = {'dept_id': id[0], 'capex':id[1]};
				$.ajax({
	                type:'POST',
	                url:'Controllers/getInfoCapex.php',
	                data: dataString,
	                success:function(json_data){
	                	var data_array = $.parseJSON(json_data);
	                    $('#id_dept').val(data_array['departemen_id']);
	                    $('#capex_number').val(data_array['capex_number']);
	                    $('#capex_desc').val(data_array['capex_desc']);
	                    $('#capex_year').val(data_array['capex_year']);
	                    $('#amount').val(data_array['amount']);
                    	document.getElementById("id_dept").disabled = true;
                   		document.getElementById("capex_number").disabled = true;
	           		}
	            }); 
			}

			function cancel() {
				modal.style.display = "none";				
				initialize()				
			}
			//add capex & update
			function add_capex(){
				var dept				= $("#id_dept").val();
				var capex_number		= $("#capex_number").val();
				var capex_desc	 		= $("#capex_desc").val().replace("'", "*");
				var capex_year			= $("#capex_year").val();
				var amount 				= $("#amount").val();

				var dataString = {'dept': dept,'capex_number': capex_number, 'capex_desc': capex_desc, 'capex_year' : capex_year, 'amount': amount};
				console.log(dataString);
				if ($('#btn_capex').val() == 'add'){
					var dt_url = 'addcapex.php';
				}else{
					var dt_url = 'editcapex.php';
				}
				
				if ((capex_number != "") && (dept != "")){
					var stat = validAmount();
					if (stat){
						$.ajax({
							type: 'POST',
							url: 'Controllers/'+dt_url,
							data: dataString,
							cache: false,
							success: function (json_data) {	
								var data_array = $.parseJSON(json_data);			
								alert(data_array[1]);
								if (data_array[0] == 1){
									location.reload();
								}		
							},
							error: function (e) {
								console.log(e.message);
								alert("error while proccess !");
							}
						});
					} 
				}else {
					alert("Field department or capex number still Empty!!!");
				}
			}
			//valid amount
			//lkm
			function validAmount(){
				var price = $('#amount').val();
				if (price < 0){
					alert('Invalid Data Amount');
					return false;
				}else{
					return true;
				}
			}
			function initialize() {
				$("#id_dept").val("");
				$("#capex_number").val("");
				$("#capex_desc").val("");
				$("#capex_year").val(new Date().getFullYear());
				$("#amount").val("0");
			}					
			
		</script>
	</body>
</html>

