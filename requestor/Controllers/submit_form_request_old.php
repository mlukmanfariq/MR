<?php 
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$headerid1=$_POST['headerid'];
	$option1=$_POST['option'];
	$status_doc1=$_POST['status_doc'];
	$status_desc1=$_POST['status_desc'];
	$remarks1=$_POST['remarks'];
	$modified_date1=$_POST['modified_date'];
	$modified_by1=$_POST['modified_by'];
	
	//--------------------------------------------------------------------------------
	$query = pg_query($conn, "SELECT trim(created_by) as created_by, last_step_dokumen FROM tbl_t_request_header where header_id = {$headerid1}");
	$fetch_query = pg_fetch_array($query);	
	$created_by = $fetch_query['created_by'];
	$last_step_dokumen = $fetch_query['last_step_dokumen'];
		
	$query = pg_query($conn, "SELECT decision_description FROM tbl_r_general_step_document where nik_user = '{$created_by}' and decision_id = {$status_doc1} and current_step = {$last_step_dokumen}");
	$fetch_query = pg_fetch_array($query);	
	$decision_description = $fetch_query['decision_description'];
	
	//--------------------------------------------------------------------------------
	$query = pg_query($conn, "SELECT next_step FROM vw_t_nextstep where header_id = {$headerid1} and decision_id = {$status_doc1}");
	$fetch_query = pg_fetch_array($query);	
	$next_step = $fetch_query['next_step'];
	
	$query = pg_query($conn, "SELECT distinct nik_user, current_step, step_description FROM tbl_r_general_step_document where nik_user = '{$created_by}' and current_step = {$next_step}");
	$fetch_query = pg_fetch_array($query);	
	$step_description = $fetch_query['step_description'];

	
	if ($option1 == 'draft') {
		$step_description = $status_desc1;
	}
	
	$query3 = pg_query($conn, "select nextval('next_history_id') as next_history_id");
	$nextid = pg_fetch_array($query3);
	$next_history_id = $nextid['next_history_id'];
	
	if ($option1 == 'clear') {
		$ssql = "DELETE FROM public.tbl_t_request_header WHERE header_id = $headerid1;
		DELETE FROM public.tbl_t_request_detail WHERE header_id = $headerid1;
				
				INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by, decision_id, decision_desc)
		VALUES($next_history_id, $headerid1, $next_step, '$step_description', '$remarks1', '$modified_date1', '$modified_by1', $status_doc1, '$decision_description');";
				
	}else {			
		$ssql = "UPDATE tbl_t_request_detail SET status_commit = 1 WHERE header_id = $headerid1;
		UPDATE tbl_t_request_header SET last_step_dokumen = $next_step WHERE header_id = $headerid1;
				
				INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by, decision_id, decision_desc)
		VALUES($next_history_id, $headerid1, $next_step, '$step_description', '$remarks1', '$modified_date1', '$modified_by1', $status_doc1, '$decision_description');";	
	}
	
	//echo $ssql;
	$query = pg_query($conn, $ssql);
	
	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		if ($option1 == 'cancel') {
			echo "Cancel Data Success... ";
		}else if ($option1 == 'draft') {
			echo "Save Data Success... ";	
		}else if ($option1 == 'send') {
			echo "Send Data Success... ";			
		}else if ($option1 == 'clear') {
			echo "Delete Data Success... ";	
		}
		
	}	
	pg_close($conn);
	// if ($option1 == 'clear') {
		// $ssql = "DELETE FROM public.tbl_t_request_header WHERE header_id = $headerid1;
				// DELETE FROM public.tbl_t_request_detail WHERE header_id = $headerid1;";
				
	// }else if ($option1 == 'draft') {
		// $ssql = "UPDATE tbl_t_request_detail SET status_commit = 1 WHERE header_id = $headerid1;
				// UPDATE tbl_t_request_header SET last_step_dokumen = $next_step WHERE header_id = $headerid1;";
				
	// }else if ($option1 == 'send') {
		// $query3 = pg_query($conn, "select nextval('next_history_id') as next_history_id");
		// $nextid = pg_fetch_array($query3);
		// $next_history_id = $nextid['next_history_id'];
		
		// $ssql = "UPDATE tbl_t_request_detail SET status_commit = 1 WHERE header_id = $headerid1;
		// UPDATE tbl_t_request_header SET last_step_dokumen = $next_step WHERE header_id = $headerid1;
		
		// INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by)
		// VALUES($next_history_id, $headerid1, $next_step, '$step_description', '$remarks1', '$modified_date1', '$modified_by1');";
					
	// }else if ($option1 == 'cancel') {
		// $query3 = pg_query($conn, "select nextval('next_history_id') as next_history_id");
		// $nextid = pg_fetch_array($query3);
		// $next_history_id = $nextid['next_history_id'];
		
		// $ssql = "UPDATE tbl_t_request_header SET last_step_dokumen = $next_step WHERE header_id = $headerid1;
				// INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by)
					// VALUES($next_history_id, $headerid1, $next_step, '$step_description', '$remarks1', '$modified_date1', '$modified_by1');";
					
	// }
?>
