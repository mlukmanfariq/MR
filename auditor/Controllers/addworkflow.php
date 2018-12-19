<?php 
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$nik1=$_POST['nik'];
	$current_step1=$_POST['current_step'];
	$curStepDesc1=$_POST['curStepDesc'];
	$dec_id1=$_POST['dec_id'];
	$dec_desc1=$_POST['dec_desc'];
	$next_step1=$_POST['next_step'];
	$nikApproval1=$_POST['nikApproval'];
	$createdDate=$_POST['txt_date'];
	$createBy=$_POST['txt_userlogin'];
	
	$query3 = pg_query($conn, "select max(rowid) + 1 as next_user from tbl_r_general_step_document");
	$nextid = pg_fetch_array($query3);
	$next_user = $nextid['next_user'];
	
	if ($current_step1==4) {
		$nikApproval1 = 'pur';
	}
	
	if ($current_step1==5) {
		$nikApproval1 = '';
	}
	
	$ssql = "INSERT INTO public.tbl_r_general_step_document(
	rowid, app_id, nik_user, current_step, step_description, decision_id, 
	decision_description, next_step, active_flag, create_date, create_by, modified_date, modified_by, nik_approval)
	VALUES ($next_user, 1, '$nik1', $current_step1, '$curStepDesc1', $dec_id1, 
	'$dec_desc1', $next_step1, 'Y', '$createdDate', '$createBy', '$createdDate', '$createBy', '$nikApproval1');";
		
	//echo $ssql;
	$query = pg_query($conn, $ssql);
		
	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo "Insert Workflow User Success... ";
	}	
	pg_close($conn);
?>
