<?php 
	
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	//$connOra = oci_connect('APPS', 'APPS', '192.7.1.232:1521/PROD');
	//$connOra = oci_connect('APPS', 'APPS', '192.6.1.221:1521/PROD');
	
	$req_id1=$_POST['req_id'];
	$pr_id1=$_POST['pr_id'];
	$create_by1=$_POST['create_by'];
	$date = date('Y-m-d H:i:s');
	
	$query3 = pg_query($conn, "select nextval('next_history_id') as next_history_id");
	$nextid = pg_fetch_array($query3);
	$next_history_id = $nextid['next_history_id'];

	$query4 = pg_query($conn, "select header_id from tbl_t_request_header where mr_no = '$req_id1'");
	$header_id = pg_fetch_array($query4);
	$headerid = $header_id['header_id'];
	
	$ssql = "UPDATE tbl_t_request_header SET pr_no = '$pr_id1', modified_date = '$date', modified_by = '$create_by1' WHERE mr_no = '$req_id1';
	INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by)
		VALUES($next_history_id, $headerid, 5, 'Finish', 'Finish', '$date', '$create_by1');";
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
