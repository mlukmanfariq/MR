
<?php
session_start();
$error='';
if(isset($_POST['login'])){
	include('db_login.php');
	if(empty($_POST['user_id']) || empty($_POST['password'])){
		$error = "Sorry, Incorrect user and password";
	}
	else{
		$user_id	= pg_escape_string($_POST["user_id"]);
		$password	= pg_escape_string($_POST["password"]);
		$user_id = stripslashes($user_id);
		$password = stripslashes($password);
		//if(is_numeric($user_id)){
			$sql = "SELECT rowid, id_user, nik, user_name, password, trim(level) as level, department, pos_title, (current_date + 32) - modified_date as expired 
			FROM tbl_r_general_user WHERE nik='$user_id' AND password= '$password' ";
			$query = pg_query($conn, $sql);
			if(pg_num_rows($query) == 0){
				$error = "Invalid User ID or Password, Try Again!";
			}else{
				$rows = pg_fetch_array($query);		
				if ($rows['expired'] <= 60) {
					if($rows['level'] == "user_depthead"){
						$error = $rows['level'];
						$_SESSION['user_depthead']= $user_id;
						echo '<script>window.location="appr/index.php"</script>';
						//header("Refresh:0; url=appr/index.php");
						//exit();
						//header('location: appr/index.php');	
					}else if($rows['level'] == "admin"){
						$_SESSION['admin']= $user_id;
						echo '<script>window.location="admin/index.php"</script>';
						//header('location:admin/index.php');
					}else if($rows['level'] == "user"){
						$_SESSION['user']= $user_id;
						echo '<script>window.location="requestor/index.php"</script>';
						//header('location:requestor/index.php');	
					}else if($rows['level'] == "user_pur"){
						$_SESSION['user_pur']= $user_id;
						echo '<script>window.location="pur/index.php"</script>';
						//header('location:pur/index.php');	
					}else if($rows['level'] == "user_view"){
						$_SESSION['user_view']= $user_id;
						echo '<script>window.location="viewer/index.php"</script>';
						//header('location:viewer/index.php');	
					}else if($rows['level'] == "auditor"){
						$_SESSION['auditor']= $user_id;
						echo '<script>window.location="auditor/index.php"</script>';
						//header('location:auditor/index.php');	
					}
				} else {
					$error =  'Your Password is expired. Please reset your password by click "I forgot my password"';
					if($rows['level'] == "user_depthead"){
						$error = $rows['level'];
						$_SESSION['user_depthead']= $user_id;
						echo '<script>window.location="appr/setting.php"</script>';						
						//header('location:appr/setting.php');	
						//header("Refresh:0; url=appr/setting.php");
						//exit();
					}else if($rows['level'] == "admin"){
						$_SESSION['admin']= $user_id;
						echo '<script>window.location="admin/setting.php"</script>';		
						//header('location:admin/setting.php');
					}else if($rows['level'] == "user"){
						$_SESSION['user']= $user_id;
						echo '<script>window.location="requestor/setting.php"</script>';
						//header('location:requestor/setting.php');	
					}else if($rows['level'] == "user_pur"){
						$_SESSION['user_pur']= $user_id;
						echo '<script>window.location="pur/setting.php"</script>';
						//header('location:pur/setting.php');	
					}else if($rows['level'] == "user_view"){
						$_SESSION['user_view']= $user_id;
						echo '<script>window.location="viewer/setting.php"</script>';
						//header('location:viewer/setting.php');	
					}else if($rows['level'] == "auditor"){
						$_SESSION['auditor']= $user_id;
						echo '<script>window.location="auditor/setting.php"</script>';
						//header('location:auditor/index.php');
					}
				}
				$_SESSION['department']= $rows['department'];
				$_SESSION['appr_mr']=0;
			}	
			pg_close($conn);
		//}else{
		//	$error = "Invalid Username or Password, Try Again!";
		//}
	}
}
?>
