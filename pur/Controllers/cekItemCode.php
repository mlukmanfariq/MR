<?php 
	
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
									

	$headerid1=$_POST['headerid'];

	$query = pg_query($conn, "SELECT count(rowid) as pending FROM public.tbl_t_request_detail where header_id = $headerid1 and coalesce(item_no,'') = '';");
	$nextid = pg_fetch_array($query);
	$countPending = $nextid['pending'];
	

	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo $countPending;
	}	
	pg_close($conn);
		
?>
