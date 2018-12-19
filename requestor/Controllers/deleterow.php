<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	if ($_REQUEST['rowid']) {
		$pid = $_REQUEST['rowid'];
		$query = pg_query($conn, "SELECT header_id FROM tbl_t_request_detail where rowid = {$pid}");
		$header = pg_fetch_array($query);	
		$header_id = $header['header_id'];

		$ssql = "DELETE FROM tbl_t_request_detail WHERE rowid = {$pid};";
		$result = pg_query($conn, $ssql);
		if(result){
			header("location: ../update_form_request.php?header_id={$header_id}");
		} 
	} else if ($_REQUEST['rowidEdit']) {
		$pid = $_REQUEST['rowidEdit'];
		$query = pg_query($conn, "SELECT header_id FROM tbl_t_request_detail where rowid = {$pid}");
		$header = pg_fetch_array($query);	
		$header_id = $header['header_id'];

		$ssql = "DELETE FROM tbl_t_request_detail WHERE rowid = {$pid};";
		$result = pg_query($conn, $ssql);
		if(result){
			header("location: ../edit_form_request.php?header_id={$header_id}");
		} 
	}
		
?>