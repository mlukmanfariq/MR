<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$dept = $_POST['dept_id'];
	$capex = $_POST['capex'];
	
	if ($dept && $capex){
		$query= pg_query($conn, "SELECT * FROM public.tbl_r_capex_dept WHERE departemen_id = '$dept' AND capex_number = '$capex' ");
		$rows = pg_fetch_array($query);
	}
	echo json_encode($rows);
?>