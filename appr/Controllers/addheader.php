<?php 
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$usersection=$_POST['user_section'];
	$userdepartment=$_POST['user_department'];
	$requestorID=$_POST['requestor_id'];
	$costCenter=$_POST['cost_center'];
	$suggestedVendor=$_POST['suggested_vendor'];
	$prNo=$_POST['pr_no'];
	$createdDate=$_POST['created_date'];
	$mrno=$_POST['mr_no'];
	$purpose=$_POST['purpose_mr'];
	$createBy=$_POST['create_by'];
	$header_id=$_POST['headerid'];
	
	$query3 = pg_query($conn, "select nextval('next_history_id') as next_history_id");
	$nextid = pg_fetch_array($query3);
	$next_history_id = $nextid['next_history_id'];
	
	$ssql = "INSERT INTO public.tbl_t_request_header(header_id, mr_no, user_section, user_department, cost_center, suggested_vendor, 
	pr_no, requestor_id, created_date, created_by, modified_date, modified_by, last_step_dokumen, purpose) 
	VALUES ($header_id, null, '$usersection', '$userdepartment', '$costCenter', '$suggestedVendor', 
	null, $requestorID, '$createdDate', '$createBy', '$createdDate', '$createBy', 0, '$purpose');
	
	INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by)
		VALUES($next_history_id, $header_id, 0, 'Save as Draft', 'New Request', '$createdDate', '$createBy');
	";
		
	//echo $ssql;
	$query = pg_query($conn, $ssql);
		
	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo "Insert Header Success... ";
	}	
	pg_close($conn);
?>
