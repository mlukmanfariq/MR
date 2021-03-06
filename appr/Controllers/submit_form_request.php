<?php 
	@require_once "Mail.php";
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	$headerid1=$_POST['headerid'];
	$option1=$_POST['option'];
	$status_doc1=$_POST['status_doc'];
	$status_desc1=$_POST['status_desc'];
	$remarks1=$_POST['remarks'];
	$modified_date1=$_POST['modified_date'];
	$modified_by1=$_POST['modified_by'];
	
	//--------------------------------------------------------------------------------
	$ssql1 = "SELECT trim(created_by) as created_by, trim(mr_no) as mr_no, trim(purpose) as purpose, last_step_dokumen FROM tbl_t_request_header where header_id = {$headerid1}";
	$query = pg_query($conn, $ssql1);
	$fetch_query = pg_fetch_array($query);	
	$created_by = $fetch_query['created_by'];
	$last_step_dokumen = $fetch_query['last_step_dokumen'];
	$mr_no = $fetch_query['mr_no'];
	$purpose = $fetch_query['purpose'];
	pg_free_result($query);

	
	$ssql2 = "SELECT decision_description FROM tbl_r_general_step_document where nik_user = '{$created_by}' and decision_id = {$status_doc1} and current_step = {$last_step_dokumen}";
	$query = pg_query($conn, $ssql2);
	$fetch_query = pg_fetch_array($query);	
	$decision_description = $fetch_query['decision_description'];
	pg_free_result($query);
	
	//--------------------------------------------------------------------------------
	$ssql3 = "SELECT next_step FROM vw_t_nextstep where header_id = {$headerid1} and decision_id = {$status_doc1}";
	$query = pg_query($conn, $ssql3);
	$fetch_query = pg_fetch_array($query);	
	$next_step = $fetch_query['next_step'];
	pg_free_result($query);
	
	
	$ssql4 = "SELECT distinct nik_user, current_step, step_description FROM tbl_r_general_step_document where nik_user = '{$created_by}' and current_step = {$next_step}";
	$query = pg_query($conn, $ssql4);
	$fetch_query = pg_fetch_array($query);		
	$step_description = $fetch_query['step_description'];
	pg_free_result($query);
	
	if ($option1 == 'draft') {
		$step_description = $status_desc1;
	}
	
	
	$ssql5 = "select nextval('next_history_id') as next_history_id";
	$query = pg_query($conn, $ssql5);
	$nextid = pg_fetch_array($query);
	$next_history_id = $nextid['next_history_id'];
	pg_free_result($query);
	
	if ($option1 == 'clear') {
		$ssql = "DELETE FROM public.tbl_t_request_header WHERE header_id = $headerid1;
		DELETE FROM public.tbl_t_request_detail WHERE header_id = $headerid1;
				
				INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by, decision_id, decision_desc)
		VALUES($next_history_id, $headerid1, $next_step, '$step_description', '$remarks1', '$modified_date1', '$modified_by1', $status_doc1, '$decision_description');";
				
	}else {			
		$ssql = "UPDATE tbl_t_request_detail SET status_commit = 1 WHERE header_id = $headerid1;
		UPDATE tbl_t_request_header SET last_step_dokumen = $next_step WHERE header_id = $headerid1;
				
				INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by, decision_id, decision_desc)
		VALUES($next_history_id, $headerid1, $next_step, '$step_description', '$remarks1', '$modified_date1', '$modified_by1', $status_doc1, '$decision_description');";	
	}
	
	//echo $ssql;
	$query = pg_query($conn, $ssql);
	
	if (!$query){
		die("could not query the database: <br />".pg_errormessage());
	}
	else{
		pg_free_result($query);		
		if ($option1 == 'cancel') {
			echo "Cancel Data Success... ";
		}else if ($option1 == 'draft') {
			echo "Save Data Success... ";	
		}else if ($option1 == 'send') {
			$ssql1 = "SELECT coalesce(email,'') as email, user_name FROM vw_t_nextstep where header_id = {$headerid1} and decision_id = {$status_doc1}";
			$query1 = pg_query($conn, $ssql1);
			$fetch_query = pg_fetch_array($query1);	
			$email = $fetch_query['email'];
			$user_name = $fetch_query['user_name'];
				
			if ($email == '') {
				echo "Send Data Success... ";
			}else {
				$subject = "MR No. ".$mr_no." Need Your Approval!";
				$from = "Notif System <noreply@polytama.co.id>";
				$to = $email;
				$body = 'MR Notification. Document MR need your approval!
Requestor	: '.$user_name.' 
Purpose	: '.$purpose.'.
				
				
Please click link address and Signin with your login!!!
Link address http://192.6.1.246/MR/index.php ';

				$host = "192.6.1.251";
				$username = "noreply@polytama.co.id";
				$password = "mag3306";

				$headers = array ('From' => $from,
				  'To' => $to,
				  'Subject' => $subject);
				$smtp = @Mail::factory('smtp',
				  array ('host' => $host,
					'auth' => true,
					'username' => $username,
					'password' => $password));
				
				$mail = @$smtp->send($to, $headers, $body);

				if (@PEAR::isError($mail)) {
				  echo("Error send Email. Email GM is not registered. " . $mail->getMessage());
				} else {
					echo "Send Data Success... ";
				}
			}
		}else if ($option1 == 'clear') {
			echo "Delete Data Success... ";	
		}else if ($option1 == 'approve') {
			$ssql1 = "SELECT coalesce(email,'') as email, user_name FROM vw_t_nextstep where header_id = {$headerid1} and decision_id = {$status_doc1}";
			$query1 = pg_query($conn, $ssql1);
			$fetch_query = pg_fetch_array($query1);	
			$email = $fetch_query['email'];
			$user_name = $fetch_query['user_name'];
				
			if ($email == '') {
				echo "Approve Data Success... ";
			}else {
				$subject = "MR No. ".$mr_no." Need Your Approval!";
				$from = "Notif System <noreply@polytama.co.id>";
				$to = $email;
				$body = 'MR Notification. Document MR need your approval!
Requestor	: '.$user_name.' 
Purpose	: '.$purpose.'.
				
				
Please click link address and Signin with your login!!!
Link address http://192.6.1.246/MR/index.php ';

				$host = "192.6.1.251";
				$username = "noreply@polytama.co.id";
				$password = "mag3306";

				$headers = array ('From' => $from,
				  'To' => $to,
				  'Subject' => $subject);
				$smtp = @Mail::factory('smtp',
				  array ('host' => $host,
					'auth' => true,
					'username' => $username,
					'password' => $password));
				
				$mail = @$smtp->send($to, $headers, $body);

				if (@PEAR::isError($mail)) {
				  echo("Error send Email. " . $mail->getMessage());
				} else {
					echo "Approve Data Success... ";
				}
			}
			
				
					
		}else if ($option1 == 'reject') {
			echo "Reject Data Success... ";	
		}
		
	}
	pg_close($conn);
	
?>
