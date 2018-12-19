<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$curStep = $_GET['step'];
	$decision_id = $_GET['decision'];
	
	//do the db query here

	$query = pg_query($conn, "SELECT * FROM public.tbl_r_general_workflow where current_step = $curStep and decision_id = $decision_id order by next_step; ");
	echo '<option value=""> -- Select Next Step -- </option>';
	while ($result = pg_fetch_array($query)){		
		echo '<option value=\"'.$result['next_step'].'\" $a>'.$result['next_step'].'</option>',PHP_EOL;
	}
?>

