<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

	$amount = 0;
	$capex = $_POST['capex'];
	
	if ($capex != 0){
		$query_balance = pg_query($conn, "SELECT amount FROM public.tbl_r_capex_dept WHERE capex_number = '$capex' ");
		$rows = pg_fetch_array($query_balance);
		$amount = $rows['amount'];	
	}
	
	echo $amount

?>