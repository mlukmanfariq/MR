<?php

	include('db_login.php');
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$nik			= $_POST["nik"];
	$email			= $_POST["email"];
	$user_id 		= stripslashes($user_id);
	$email 			= stripslashes($email);
	$nik 			= stripslashes($nik);
	$password		="start";
	if(is_numeric($nik)){
		$query = pg_query($conn, "SELECT * FROM tbl_r_general_user WHERE nik='$nik'");	
		if(pg_num_rows($query) == 0){
			echo'
			<div class="alert alert-danger" id="success-alert">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<strong>Invalid User ID or NIK or internal email, Try Again!</strong>
			</div>';
		}else{
			$update = pg_query($conn, "UPDATE tbl_r_general_user  SET password='$password' WHERE nik='$nik'");
			echo'
			<div class="alert alert-success" id="success-alert">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<strong>you have successfully reset password<br> Pleas sign in with your ID and password = start</strong>
			</div>';
		}	
	pg_close($conn);
	}else{	
		echo'
		<div class="alert alert-danger" id="success-alert">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>Invalid User ID or NIK or internal email, Try Again!</strong>
		</div>';
	}
		

?>
