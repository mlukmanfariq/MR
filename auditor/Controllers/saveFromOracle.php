<?php 
	
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$connOra = oci_connect('APPS', 'APPS', '192.7.1.232:1521/PROD');
	
	$req_id1=$_POST['req_id'];
	$pr_id1=$_POST['pr_id'];
	$create_by1=$_POST['create_by'];
	$date = date('Y-m-d');
	
	$ssql = "UPDATE tbl_t_request_header SET pr_no = $pr_id1, modified_date = '$date', modified_by = '$create_by1' WHERE requisition_header_id = $requisition_header_id1;";
	$query = pg_query($conn, $ssql);

	if (!$query){
		 die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo "Download Data from Oracle Success... ";
	}	
	pg_close($conn);

		
?>
