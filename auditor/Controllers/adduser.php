<?php 
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$id_user1=$_POST['id_user'];
	$nik1=$_POST['nik'];
	$user1=$_POST['user'];
	$dept1=$_POST['dept'];
	$section1=$_POST['section'];
	$password1=$_POST['password'];
	$level1=$_POST['level'];
	$location1=$_POST['location'];
	$createdDate=$_POST['txt_date'];
	$createBy=$_POST['txt_userlogin'];
	
	$query3 = pg_query($conn, "select coalesce(nik,'') as nik from tbl_r_general_user where nik ='$nik1' and active_flag = 'N'");
	$nextid = pg_fetch_array($query3);
	$nikExist = $nextid['nik'];
	
	if ($nikExist == '') {
		$query3 = pg_query($conn, "select nextval('next_user') as next_user");
		$nextid = pg_fetch_array($query3);
		$next_user = $nextid['next_user'];
		
		$ssql = "INSERT INTO public.tbl_r_general_user(rowid, id_user, nik, user_name, password, level, department, active_flag, 
		create_date, create_by, modified_date, modified_by, location_id, section) 
		VALUES ($next_user, $id_user1, '$nik1', '$user1', '$password1', '$level1', '$dept1', 'Y', 
		'$createdDate', '$createBy', '$createdDate', '$createBy', $location1, '$section1');";
		
		$query = pg_query($conn, $ssql);
		
		if (!$query){
			die("could not query the database: <br />".pg_errormessage());
		} else{
			pg_free_result($query);		
			echo "Insert User Success... ";
		}	
	} else {
		echo "Username has exist...! Please input another Nik/Username!";
	}
		
	
	pg_close($conn);
?>
