<?php 
	
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
									
	$itemNo1=$_POST['itemNo'];
	$description1=$_POST['description'];
	$reqtQty1=$_POST['reqtQty'];
	$uom1=$_POST['uom'];
	$neededDate=$_POST['needed_date'];
	$lastOrderQty1=$_POST['lastOrderQty'];
	$lastOrderdate1=$_POST['lastOrderdate'];
	$minStock1=$_POST['minStock'];
	$maxStock1=$_POST['maxStock'];
	$stockBal1=$_POST['stockBal'];
	$purpose1=$_POST['purpose'];
	$createBy=$_POST['create_by'];
	$createdDate=$_POST['created_date'];
	$headerid1=$_POST['headerid'];

	
	$query = pg_query($conn, "SELECT coalesce(max(row_detail_id),0) + 1 as row_detail_id FROM tbl_t_request_detail where header_id = {$headerid1}");
	$detailid = pg_fetch_array($query);	
	$row_detail_id = $detailid['row_detail_id'];

	$query = pg_query($conn, "select nextval('next_rowid_detail') as next_rowid_detail");
	$next_rowid_detail = pg_fetch_array($query);
	$next_rowid = $next_rowid_detail['next_rowid_detail'];
	
	$ssql = "INSERT INTO public.tbl_t_request_detail(rowid, header_id, row_detail_id, item_no, desc_material, req_qty, uom, last_order_date, last_order_qty, 
	needed_date, min_stock, max_stock, stock_bal, purpose, status_commit, created_date, created_by, modified_date, modified_by) 
	VALUES($next_rowid, $headerid1, $row_detail_id, '$itemNo1', '$description1', $reqtQty1, '$uom1', '$lastOrderdate1', $lastOrderQty1, 
	'$neededDate', $minStock1, $maxStock1, $stockBal1, '$purpose1', 0, '$createdDate', '$createBy', '$createdDate', '$createBy');";

	//echo $ssql;
	$query = pg_query($conn, $ssql);

	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo "Insert Detail Success... ";
	}	
	pg_close($conn);
		
?>
