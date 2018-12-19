<?php 
	
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
									
	$headerid1=$_POST['headerid'];
	$preparer_id1=$_POST['preparer_id'];
		
	if($preparer_id1 == 583) {
		$preparer_id1 = 582;		
	}

	$ssql = "INSERT INTO public.requisition_interface_all
	SELECT authorization_status, header_id, category_id, charge_account_id, $preparer_id1 as preparer_id, current_date, currency_code, 
	requestor_id, organization_id, trim(destination_type_code) as destination_type_code, trim(purpose_mr) as purpose_mr, mr_no as interface_source_code, trim(desc_material) as desc_material, trim(item_no) as item_no, $preparer_id1 as preparer_id, 
	req_qty, null, header_id as requisition_header_id, requisition_type, source_type_code, trim(uom) as uom, unit_price, null, needed_date, location_id, 0 as oracle_flag
	FROM public.vw_t_requisition_interface
	WHERE header_id = {$headerid1};";	
	
	//echo $ssql;
	$query = pg_query($conn, $ssql);

	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo "Update Document Success... ";
	}	
	pg_close($conn);
		
?>
