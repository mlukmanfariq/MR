<?php 
	include("akses.php");
	include("../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		
	$dept_head_name = pg_escape_string($_SESSION['dept_head_name']);
	$user = pg_escape_string($_SESSION['user']);
	$header_id = $_GET['header_id'];
	$datetime = date('Y-m-d H:i:s');
	
	$dept_head_name = pg_escape_string($_SESSION['dept_head_name']);
	$gm_name = pg_escape_string($_SESSION['general_manager']);
	$user = pg_escape_string($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Dashboard">
		<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

		<title>User</title>

		<!-- Bootstrap core CSS -->
		<link href="../assets/css/bootstrap.css" rel="stylesheet">
		<!--external css-->
		<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="../assets/iCheck/all.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/zabuto_calendar.css">
		<link rel="stylesheet" type="text/css" href="../assets/js/gritter/css/jquery.gritter.css" />
		<link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">    
		
		<!-- DataTables CSS -->
		<link href="../assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

		<!-- DataTables Responsive CSS -->
		<link href="../assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="../assets/dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="../assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		
		<!-- Custom styles for this template -->
		<link href="../assets/css/style.css" rel="stylesheet">
		<link href="../assets/css/style-responsive.css" rel="stylesheet">
		<link rel="shortcut icon" href= "../assets/img/masplene.ico" />

		<script src="../assets/js/chart-master/Chart.js"></script>
	</head>

	<body>
		<section id="container" >
			<!--header start-->
			<header class="header black-bg">
				<div class="sidebar-toggle-box">
					  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
				</div>
				<!--logo start-->
				<a href="index.php" class="logo"><b>User</b></a>
				<!--logo end-->
				<div class="top-menu">
					<ul class="nav pull-right top-menu" >
						<li><a class="logout" href="../index.php">Logout</a></li>
					</ul>
				</div>
			</header>
			<!--header end-->
			<!--MAIN SIDEBAR MENU -->
			<!--sidebar start-->
			<aside>
				<div id="sidebar"  class="nav-collapse ">
					<!-- sidebar menu start-->
					<ul class="sidebar-menu" id="nav-accordion">
						<p class="centered"><a href="#"><img src="../assets/img/user.png" class="img-circle" width="60"></a></p>
						<h5 class="centered">
							<?php echo $_SESSION['user'].'</br>'; 
								$query = pg_query($conn, "SELECT * FROM user_comp WHERE id_user='{$_SESSION['user']}'");
								$username = pg_fetch_array($query);
								echo $username['user_name'];
							?>
						</h5>
						<li class="mt">
							<a href="index.php">
								<i class="fa fa-home"></i>
								<span>Home</span>
							</a>
						</li>
						<li class="sub-menu">
							<a href="form_request.php" >
								<i class="fa fa-book"></i>
								<span>Form Request</span>
							</a>
						</li>
						<li class="sub-menu">
							<a href="view_report.php" >
								<i class="fa fa-table"></i>
								<span>View Report</span>
							</a>
						</li>
					</ul>
				 <!-- sidebar menu end-->
				</div>
			</aside>
			<!--sidebar end-->
			
			<!-- MAIN CONTENT -->
			<!--main content start-->
			<section id="main-content">
				<section class="wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-primary">
								<div class="panel-heading">Purchase Requisition Application Form</div>
								<!--<form class="form-horizontal style-form" action="" method="get"> -->
									<?php										
										$query = pg_query($conn, "SELECT * FROM tbl_t_request_header WHERE header_id = {$header_id} and create_by = '{$user}'");
										$view = pg_fetch_array($query);
																								
									?>
									<div class="panel-body">
										<div class="form-group">
											<input type="hidden" id="headerid" name="headerid" value="<?php echo $header_id;?>" readonly/>
											<input type="hidden" id="dept_head_name" name="dept_head_name" value="<?php echo $dept_head_name;?>" readonly/>
											<input type="hidden" id="gm_name" name="gm_name" value="<?php echo $gm_name;?>" readonly/>
											<input type="hidden" id="user" name="user" value="<?php echo $user;?>" readonly/>
											<input type="hidden" id="datetime" name="datetime" value="<?php echo $datetime;?>" readonly/>
											<table cellpadding="6" class="table table-bordered">
												<tr>
													<td>Section</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_section" name="txt_section" value="<?php echo $view['user_section'];?>"/>
													</td>

													<td colspan="2">Suggested Vendor :</td>

													<td>PR No.</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_NoPR" name="txt_NoPR" value="<?php echo $view['pr_no'];?>" readonly/>
													</td>
												</tr>
												<tr>
													<td>Department</td>
													<td>:</td>
													<td>
														<input class="k-textbox textbox-custom" id="txt_Department" name="txt_Department" value="<?php echo $view['user_department'];?>" readonly/>
													</td>

													<td colspan="2" rowspan="2">
														<textarea rows="4" cols="40" class="k-textbox textbox-custom" id="txt_suggestedVendor" name="txt_suggestedVendor"><?php echo $view['suggested_vendor'];?></textarea>
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

													<td>Needed by Date</td>
													<td>:</td>
													<td>
														<input type="date" id="date" name="txt_neededDate" class="k-textbox textbox-custom" value="<?php echo $view['needed_date'];?>"/>
														<span class="error"><?php echo $error_date?></span>
													</td>
												</tr>
											</table>				
											<div class="panel-heading"><button id="add_data" name="add_data" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</button></div>											
											<?php
												$cek = pg_query($conn, "SELECT * FROM vw_t_requestall where header_id = {$header_id} and create_by = '{$user}' ");
												$cek_row = pg_num_rows($cek);
												echo '<div class="col-lg-12">';
													echo '<div class="panel panel-primary">';														
														echo '';
														// echo '<div class="panel-heading"><a href="add-data.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a></div>';
														echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">';
															echo '<thead>';
																echo '<tr>';
																	echo '<th style="width:36px"><center></th>';
																	echo '<th><center>No</th>';
																	echo '<th><center>Item No</th>';
																	echo '<th><center>Description of Material</th>';
																	echo '<th><center>Reqt Qty</th>';
																	echo '<th><center>UOM</th>';
																	echo '<th><center>Last Order Date</th>';
																	echo '<th><center>Last Order Qty</th>';
																	echo '<th><center>Min. Stock</th>';
																	echo '<th><center>Max. Stock</th>';
																	echo '<th><center>Stock Bal.</th>';
																	echo '<th><center>Purpose</th>';
																echo '</tr>';
															echo '</thead>';
															if($cek_row > 0){
																$per_page = 20;
																$page_query = pg_query($conn, "SELECT COUNT(*) FROM vw_t_requestall where header_id = {$header_id} and create_by = '{$user}'");
																$pages = ceil(pg_result($page_query, 0) / $per_page);
																$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
																$start = ($page - 1) * $per_page;
																$no = 1 + ($page - 1) * $per_page;
																$query = pg_query($conn, "SELECT * FROM vw_t_requestall where header_id = {$header_id} and create_by = '{$user}' ORDER BY row_detail_id OFFSET $start LIMIT $per_page");
																while ($result = pg_fetch_array($query)){							
																	echo '<tbody>';
																		echo '<tr>';
																			echo '<td><center><a class="btn btn-danger-sm" name="delete" href="Controllers/deleterow.php?rowidedit='.$result['rowid'].'"> <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o "></i></button></td>';
																			echo '<td><center>'.$no.'</td>';
																			echo '<td><center>'.$result['item_no'].'</td>';
																			echo '<td><center>'.$result['desc_material'].'</td>';
																			echo '<td><center>'.$result['req_qty'].'</td>';
																			echo '<td><center>'.$result['uom'].'</td>';
																			echo '<td><center>'.$result['last_order_date'].'</td>';
																			echo '<td><center>'.$result['last_order_qty'].'</td>';
																			echo '<td><center>'.$result['min_stock'].'</td>';
																			echo '<td><center>'.$result['max_stock'].'</td>';
																			echo '<td><center>'.$result['stock_bal'].'</td>';
																			echo '<td><center>'.$result['purpose'].'</td>';
																		echo '</tr>';
																	echo '</tbody>';
																	$no ++;
																}
															}else{
																echo '<td colspan=11 class="huge"><center>No Data Row</td>';
															}
														echo '</table></br>';
													echo '</div>';
												echo '</div>';
													// if($pages >= 1 && $page <= $pages){
														// for($x=1; $x<=$pages; $x++){			
															// echo ($x == $page) ? 
															// '<a class="btn btn-paging" href="?header='.$header_id.'?page='.$x.'">'.$x.'</a>' : ' <a class="btn btn-paging2" href="?header='.$header_id.'?page='.$x.'">'.$x.'</a> ';
														// }
													// }
											?>
										</div>										
									</div>	
								<!--</form> -->
									&nbsp; &nbsp; &nbsp;
									<button name="cancel" class="btn btn-danger" onclick="cancelInsert()">Cancel Request</button>								
									<button type="submit" id="submitDraft" name ="save" class="btn btn-warning" onclick="submitDraft()">Save as Draft</button>
									<button type="submit" id="submit" name ="save" class="btn btn-success" onclick="submitDeptHead()">Send to Dept Head</button>
									<!-- <input type="button"  class="btn btn-info" value="Print" onclick="PrintDoc()" /> -->						
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
											<input class="k-textbox textbox-custom" id="txt_itemNo" name="txt_itemNo" value="<?php echo $itemNo;?>" readonly/>
										</td>

										<td>Description of Material</td>
										<td>:</td>
										<td>
											<textarea rows="2" cols="20" class="k-textbox textbox-custom" id="txt_Description" name="txt_Description"></textarea>
											
										</td>
									</tr>
									<tr>
										<td>Reqt Qty.</td>
										<td>:</td>
										<td>
											<input type="number" class="k-textbox textbox-custom" id="txt_ReqtQty" name="txt_ReqtQty"/>
										</td>
										
										<td>UOM</td>
										<td>:</td>
										<td>
											<input class="k-textbox textbox-custom" id="txt_UOM" name="txt_UOM"/>
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
								<button type="button" id="adddata" name ="adddata" class="btn btn-success" onclick="addRow()"><span class="glyphicon glyphicon-saved"></span>&nbsp; Add Row</button>&nbsp; &nbsp; 
								<button type="button" id="cancel" name="cancel" class="btn btn-warning" onclick="cancel()"><span class="glyphicon glyphicon-retweet"></span>&nbsp; Cancel</button>																							
						</div>
					  </div>
					
					</div>
				</section>
			</section>
			<!--main content end-->
			<!--footer start-->
			<footer class="site-footer">
				<div class="text-center">
				  © 2017 Copyright: PT POLYTAMA PROPINDO
					<a href="index.php" class="go-top">
						<i class="fa fa-angle-up"></i>
					</a>
				</div>
			</footer>
			<!--footer end-->
		</section>

		<!-- js placed at the end of the document so the pages load faster -->
		<script src="../assets/js/jquery.js"></script>
		<script src="../assets/js/jquery-1.8.3.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="../assets/js/jquery.scrollTo.min.js"></script>
		<script src="../assets/js/jquery.nicescroll.js" type="text/javascript"></script>
		<script src="../assets/js/jquery.sparkline.js"></script>
		<!--common script for all pages-->
		<script src="../assets/js/common-scripts.js"></script>
		<script src="../assets/iCheck/icheck.min.js"></script>
		<script>
			$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			  checkboxClass: 'icheckbox_flat-green',
			  radioClass: 'iradio_flat-green'
			});
		</script>
		<script type="text/javascript">
			function header(){

				var txt_section			= $("#txt_section").val();
				var txt_Department		= $("#txt_Department").val();
				var txt_deptHeadName 	= $("#dept_head_name").val();
				var txt_CostCenter		= $("#txt_CostCenter").val();
				var txt_suggestedVendor	= $("#txt_suggestedVendor").val();
				var txt_NoPR 			= $("#txt_NoPR").val();
				var txt_user			= $("#user").val();
				var txt_neededDate		= $("#txt_neededDate").val();
				var txt_date			= $("#txt_date").val();
				var txt_headerid		= $("#headerid").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'user_section='+ txt_section + '&user_department='+ txt_Department + '&dept_head_name='+ txt_deptHeadName + '&cost_center='+ txt_CostCenter 
								+ '&suggested_vendor='+ txt_suggestedVendor  + '&pr_no='+ txt_NoPR  + '&create_by='+ txt_user  
								+ '&needed_date='+ txt_neededDate  + '&created_date='+ txt_date + '&headerid='+ txt_headerid;
				console.log(dataString);
				$.ajax({
					type: 'POST',
					url: 'Controllers/addheader.php',
					//data: {'myData':dataString},
					data: dataString,
					cache: false,
					success: function (result) {
						alert(result);
						initialize();
						modal.style.display = "none";
						
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});
				
			}
			
			function addRow(){

				var txt_itemNo			= $("#txt_itemNo").val();
				var txt_Description		= $("#txt_Description").val();
				var txt_ReqtQty 		= $("#txt_ReqtQty").val();
				var txt_UOM				= $("#txt_UOM").val();
				var txt_lastOrderQty	= $("#txt_lastOrderQty").val();
				var txt_lastOrderdate 	= $("#txt_lastOrderdate").val();
				var txt_minStock		= $("#txt_minStock").val();
				var txt_maxStock		= $("#txt_maxStock").val();
				var txt_stockBal		= $("#txt_stockBal").val();
				var txt_Purpose			= $("#txt_Purpose").val();
				var txt_headerid		= $("#headerid").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'itemNo='+ txt_itemNo + '&description='+ txt_Description + '&reqtQty='+ txt_ReqtQty + '&uom='+ txt_UOM 
								+ '&lastOrderQty='+ txt_lastOrderQty  + '&lastOrderdate='+ txt_lastOrderdate  + '&minStock='+ txt_minStock  
								+ '&maxStock='+ txt_maxStock  + '&stockBal='+ txt_stockBal + '&purpose='+ txt_Purpose + '&headerid='+ txt_headerid;
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
						window.location.href = "edit_form_request.php?header_id=" + txt_headerid;
						
					},
					error: function (e) {
						console.log(e.message);
						alert("error while proccess !");
					}
				});				
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
			
			function initialize() {
				$("#txt_itemNo").val("Generate By System");
				$("#txt_Description").val("");
				$("#txt_ReqtQty").val("0");
				$("#txt_UOM").val("");
				$("#txt_lastOrderQty").val("0");
				$("#txt_minStock").val("0");
				$("#txt_maxStock").val("0");
				$("#txt_stockBal").val("0");
				$("#txt_Purpose").val("");
			}
			
			function cancel() {
				modal.style.display = "none";
				initialize()				
			}
			
			// Get the modal
			var modal = document.getElementById('myModal');

			// Get the button that opens the modal
			var btn = document.getElementById("add_data");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
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
			
			function cancelInsert(){
				var txt_option			= "cancel";
				var txt_headerid		= $("#headerid").val();
				var txt_status_doc		= "100";
				var txt_status_desc		= "Cancel by User";
				var txt_remarks			= "Cancel by User";
				var txt_modified_date	= $("#datetime").val();
				var txt_modified_by		= $("#user").val();
				
				//var dataString = JSON.stringify(postData);
				var dataString = 'option='+ txt_option + '&status_doc='+ txt_status_doc + '&status_desc='+ txt_status_desc + '&remarks='+ txt_remarks + '&modified_date='+ txt_modified_date 
									+ '&modified_by='+ txt_modified_by + '&headerid='+ txt_headerid;
				console.log(dataString);
				if (confirm('Are you sure you want to cancel this request?')) {
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
				var txt_option			= "draft";
				var txt_headerid		= $("#headerid").val();
				var txt_status_doc		= "0";
				var txt_status_desc		= "Save as Draft";
				var txt_remarks			= "Save as Draft";
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
		<script>
		// if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
			// jQuery(function($){ //on document.ready
				// $('#txt_date').datepicker();
				// $('#txt_neededDate').datepicker();
			// })
		// }
		</script>
		<script type="text/javascript">
			var datefield=document.createElement("input")
			datefield.setAttribute("type", "date")
			if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
				document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
				document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
				document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n') 
			}
		</script>
		<style type="text/css">
			.error {
				color: red;
				padding-left: .5em;
			}
		</style>
	</body>
</html>

