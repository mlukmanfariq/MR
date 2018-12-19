<?php 
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$usersection=$_POST['user_section'];
	$userdepartment=$_POST['user_department'];
	$requestorID=$_POST['requestor_id'];
	$costCenter=$_POST['cost_center'];
	$suggestedVendor=$_POST['suggested_vendor'];
	$prNo=$_POST['pr_no'];
	$createdDate=$_POST['created_date'];
	$mrno=trim($_POST['mr_no']);
	$purpose=$_POST['purpose_mr'];
	$createBy=$_POST['create_by'];
	$header_id=$_POST['headerid'];
	$option1=$_POST['option'];
	
	$query = pg_query($conn, "select nextval('next_mr_no') as next_mr_no");
	$nextid = pg_fetch_array($query);
	$next_mr_no = $nextid['next_mr_no'];
	
	if ($option1 <> 'addrow'){
		if ($mrno == '') {
			if ($next_mr_no < 10) {
				$mrno = date("Y") . '000' . $next_mr_no;
			} else if (($next_mr_no >= 10) && ($next_mr_no < 100)) {
				$mr_no = date("Y") . '00' . $next_mr_no;
			}  else if (($next_mr_no >= 100) && ($next_mr_no < 999)) {
				$mrno = date("Y") . '0' . $next_mr_no;
			} else {
				$mrno = date("Y") . $next_mr_no;
			}
		}
		
		$ssql = "UPDATE public.tbl_t_request_header 
		SET cost_center = '$costCenter', 
		suggested_vendor = '$suggestedVendor', requestor_id = $requestorID, purpose = '$purpose', mr_no = '$mrno', 
		modified_date = '$createdDate', modified_by = '$createBy' 
		WHERE header_id = $header_id;";
	} else {
		$ssql = "UPDATE public.tbl_t_request_header 
		SET cost_center = '$costCenter', 
		suggested_vendor = '$suggestedVendor', requestor_id = $requestorID, purpose = '$purpose', 
		modified_date = '$createdDate', modified_by = '$createBy' 
		WHERE header_id = $header_id;";
	}
	
	//echo $ssql;
	$query = pg_query($conn, $ssql);
		
	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		echo "Update Header Success... ";
	}	
	pg_close($conn);
?>
