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
	$nocapex1=$_POST['nocapex'];
	$purpose1=$_POST['purpose'];
	$createBy=$_POST['create_by'];
	$createdDate=$_POST['created_date'];
	$headerid1=$_POST['headerid'];
	$leadtime1=$_POST['leadtime'];
	$rowid1=$_POST['rowid'];
	$category_id1=$_POST['category_id'];
	$organization_id1=$_POST['organization_id'];
	$destination_type_code1=$_POST['destination_type_code'];

	
	if ($leadtime1 > 0) {
		$ssql = "UPDATE public.tbl_t_request_detail
		SET item_no = '$itemNo1', desc_material = '$description1', req_qty = $reqtQty1, uom = '$uom1', last_order_date = '$lastOrderdate1',
		last_order_qty = $lastOrderQty1, min_stock = $minStock1, max_stock = $maxStock1, stock_bal = $stockBal1, no_capex = '$nocapex1',
		category_id = '$category_id1', organization_id = '$organization_id1', destination_type_code = '$destination_type_code1', 
		estimate_leadtime = $leadtime1,
		modified_date = '$createdDate', modified_by = '$createBy'  
		where rowid = $rowid1;
		UPDATE public.tbl_t_request_detail
		SET needed_date = current_date + interval '1' day * estimate_leadtime
		where rowid = $rowid1;";
	} else {
		$ssql = "UPDATE public.tbl_t_request_detail
		SET item_no = '$itemNo1', desc_material = '$description1', req_qty = $reqtQty1, uom = '$uom1', last_order_date = '$lastOrderdate1',
		last_order_qty = $lastOrderQty1, needed_date = '$neededDate', min_stock = $minStock1, max_stock = $maxStock1, stock_bal = $stockBal1,
		category_id = '$category_id1', organization_id = '$organization_id1', destination_type_code = '$destination_type_code1', no_capex = '$nocapex1',
		estimate_leadtime = DATE_PART('day', '$neededDate'::timestamp - '$createdDate'::timestamp) + 10,
		modified_date = current_date, modified_by = '$createBy'  
		where rowid = $rowid1;";	
	}
	

	//echo $ssql;
	$query = pg_query($conn, $ssql);

	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo "Update Detail Success... ";
	}	
	pg_close($conn);
		
?>
