<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$dept_id = $_REQUEST["header_id"];
	
	$query =  pg_query($conn, "SELECT * FROM public.vw_t_requisition_to_oracle where header_id = $dept_id");
	$view = pg_fetch_array($query);
	echo $view["authorization_status"];
	echo '
		<input type = "" class="k-textbox textbox-custom" id="txt_authorization_status" name="txt_authorization_status"  value="'<?php echo $view["authorization_status"]?>'" readonly/></br>
		

	';

	
?>

