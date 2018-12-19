<?php 
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$dept_id 		= $_POST['dept'];
	$capex_number 	= $_POST['capex_number'];
	$capex_desc 	= $_POST['capex_desc'];
	$capex_year 	= $_POST['capex_year'];
	$amount 		= $_POST['amount'];

	$update_capex = "UPDATE public.tbl_r_capex_dept SET capex_desc = '$capex_desc', capex_year = '$capex_year', amount = $amount WHERE departemen_id = $dept_id AND capex_number = '$capex_number' ";
	$query = pg_query($conn, $update_capex);
	$error = "";
	$dt_error = 0;
	if (!$query){
		//die("could not query the database: <br />".pg_errormessage());
		$error = 'Update Capex Master Failed... ';
	}
	else{
		pg_free_result($query);		
		$error = "Update Capex Master Success... ";
		$dt_error = 1;
	}
	$data = array($dt_error, $error);
	echo json_encode($data);
	pg_close($conn);
?>
