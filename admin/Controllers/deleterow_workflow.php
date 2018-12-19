<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	if ($_REQUEST['rowid']) {
		$pid = $_REQUEST['rowid'];
		
		$ssql = "UPDATE tbl_r_general_step_document SET active_flag = 'N' WHERE rowid = {$pid};";
		$result = pg_query($conn, $ssql);
		if(result){
			header("location: ../view_user_workflow.php");
		} 
	}
		
?>