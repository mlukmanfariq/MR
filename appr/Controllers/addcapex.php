<?php 
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$dept 			= $_POST['dept'];
	$capex_number 	= $_POST['capex_number'];
	$capex_desc 	= $_POST['capex_desc'];
	$capex_year 	= $_POST['capex_year'];
	$amount 		= $_POST['amount'];

	$input_capex = "INSERT INTO public.tbl_r_capex_dept(departemen_id, capex_number, capex_desc, capex_year, amount) 
	VALUES ($dept, '$capex_number', '$capex_desc', '$capex_year', $amount)";

	$query = pg_query($conn, $input_capex);
	$error = "";
	$dt_error = 0;
	if (!$query){
		//die("could not query the database: <br />".pg_errormessage());
		$error = 'Insert Capex Master Failed... ';
	}
	else{
		pg_free_result($query);		
		$error = "Insert Capex Master Success... ";
		$dt_error = 1;
	}
	$data = array($dt_error, $error);
	echo json_encode($data);
	pg_close($conn);
?>
