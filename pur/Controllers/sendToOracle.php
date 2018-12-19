<?php 
	
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	//$connOra = oci_connect('APPS', 'APPS', '192.6.1.234:1521/PROD');
	$connOra = oci_connect('APPS', 'APPS', '192.6.1.221:1521/PROD');
	
	$header_id1=$_POST['header_id'];
	$create_by1=$_POST['create_by'];
	$date = date('Y-m-d H:i:s');
	$error = 0;
	$rowcount = 0;
	$rowinsert = 0;
	
	$ssql1 = "SELECT count(*) as rowcount FROM requisition_interface_all where batch_id = $header_id1 and oracle_flag = 0";
	$query1 = pg_query($conn, $ssql1);
	$fetch_query = pg_fetch_array($query1);	
	$rowcount = $fetch_query['rowcount'];
	
	$ssql2 = "SELECT distinct authorization_status, batch_id, category_id, charge_account_id, created_by, creation_date, currency_code, deliver_to_requestor_id, 
	destination_organization_id, destination_type_code, header_description, interface_source_code, trim(item_description) as item_description, trim(item_segment1) as item_segment1, preparer_id, 
	quantity, req_number_segment1, requisition_header_id, requisition_type, source_type_code, unit_of_measure, unit_price, line_attribute9, 
	need_by_date, deliver_to_location_id, oracle_flag, note_to_receiver
	FROM requisition_interface_all where batch_id = $header_id1 and oracle_flag = 0"; 
	$query = pg_query($conn, $ssql2);

	while ($result = pg_fetch_array($query)){		
		If (!$connOra) 
		{
			$e_connect = "connect error..." . oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}	
		else 
		{	
			$authorization_status1=trim($result['authorization_status']);
			$batch_id1=trim($result['batch_id']);
			$category_id1=trim($result['category_id']);
			$charge_account_id1=trim($result['charge_account_id']);
			$created_by1=trim($result['created_by']);
			$creation_date1=date("m/d/Y H:i:s", strtotime(trim($date)));
			$currency_code1=trim($result['currency_code']);
			$deliver_to_requestor_id1=trim($result['deliver_to_requestor_id']);
			$destination_organization_id1=trim($result['destination_organization_id']);
			$destination_type_code1=trim($result['destination_type_code']);
			$header_description1=trim($result['header_description']);
			$interface_source_code1=trim(strval($result['interface_source_code']));
			$item_description1=trim(str_replace('"', '*inch', $result['item_description']));
			$item_segment11=trim($result['item_segment1']);
			$preparer_id1=trim($result['preparer_id']);
			$quantity1=trim($result['quantity']);
			$req_number_segment11=trim($result['req_number_segment1']);
			$requisition_header_id1 = trim($result['requisition_header_id']);
			$requisition_type1=trim($result['requisition_type']);
			$source_type_code1=trim($result['source_type_code']);
			$unit_of_measure1=trim($result['unit_of_measure']);
			$unit_price1=trim($result['unit_price']);
			$line_attribute91=trim($result['line_attribute9']);
			$need_by_date1=date("m/d/Y", strtotime(trim($result['need_by_date'])));
			$deliver_to_location_id1=trim($result['deliver_to_location_id']);
			$note_to_receiver1=trim($result['note_to_receiver']);

			If (!$connOra) 
			{
				$e_connect = "connect error..." . oci_error();
				trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}	
			else 
			{		
				$sql = " BEGIN PSP_INSERT_INTERFACE_ALL_PROC(:deliver_to_location_id, 
				:deliver_to_requestor_id, 
				:authorization_status, 
				:requisition_header_id, 
				:requisition_type,
				:creation_date, 
				:created_by, 
				:quantity,  
				:unit_price, 
				:item_segment, 
				:item_description, 
				:category_id, 
				:currency_code, 
				:preparer_id, 
				:charge_account_id,
				:source_type_code, 
				:header_description, 
				:batch_id, 
				:destination_type_code, 
				:destination_organization_id, 
				:interface_source_code, 
				:unit_of_measure, 
				:need_by_date,
				:note_to_receiver
				); END;";  //EXECUTE PROCEDURE	             
				$stid = oci_parse($connOra,$sql); 
				
				oci_bind_by_name($stid, ":authorization_status", $authorization_status1, 25);
				oci_bind_by_name($stid, ":batch_id", $batch_id1, 25);
				oci_bind_by_name($stid, ":category_id", $category_id1, 25);
				oci_bind_by_name($stid, ":charge_account_id", $charge_account_id1, 25);
				oci_bind_by_name($stid, ":created_by", $created_by1, 25);
				oci_bind_by_name($stid, ":creation_date", $creation_date1, 25);
				oci_bind_by_name($stid, ":currency_code", $currency_code1, 25);
				oci_bind_by_name($stid, ":deliver_to_requestor_id", $deliver_to_requestor_id1, 25);
				oci_bind_by_name($stid, ":destination_organization_id", $destination_organization_id1, 25);
				oci_bind_by_name($stid, ":destination_type_code", $destination_type_code1, 25);
				oci_bind_by_name($stid, ":header_description", $header_description1);
				oci_bind_by_name($stid, ":interface_source_code", $interface_source_code1, 25);
				oci_bind_by_name($stid, ":item_description", $item_description1);
				oci_bind_by_name($stid, ":item_segment", $item_segment11);
				oci_bind_by_name($stid, ":preparer_id", $preparer_id1, 25);
				oci_bind_by_name($stid, ":quantity", $quantity1, 25);
				oci_bind_by_name($stid, ":requisition_header_id", $requisition_header_id1, 25);
				oci_bind_by_name($stid, ":requisition_type", $requisition_type1, 25);
				oci_bind_by_name($stid, ":source_type_code", $source_type_code1, 25);
				oci_bind_by_name($stid, ":unit_of_measure", $unit_of_measure1, 25);
				oci_bind_by_name($stid, ":unit_price", $unit_price1, 25);
				oci_bind_by_name($stid, ":line_attribute9", $line_attribute91, 25);
				oci_bind_by_name($stid, ":need_by_date", $need_by_date1, 25);
				oci_bind_by_name($stid, ":deliver_to_location_id", $deliver_to_location_id1, 25);
				oci_bind_by_name($stid, ":note_to_receiver", $note_to_receiver1, 25);
				$no_mr = $interface_source_code1;
				$r = oci_execute($stid);
								
				if (!$r) 
				{	
					$error = 1;	
				} else {					
					$rowinsert = $rowinsert + 1;				
				}		
			}
		}		
	}
	oci_free_statement($stid);
	
	if ($rowinsert == $rowcount) {
		$query3 = pg_query($conn, "select nextval('next_history_id') as next_history_id");
		$nextid = pg_fetch_array($query3);
		$next_history_id = $nextid['next_history_id'];
		
		$ssql = "UPDATE requisition_interface_all SET oracle_flag = 1, requisition_header_id = $requisition_header_id1 WHERE batch_id = $header_id1;  
		UPDATE tbl_t_request_header SET requisition_header_id = $requisition_header_id1 WHERE header_id = $header_id1;
		INSERT INTO public.tbl_t_document_history(rowid, header_id, status_doc, status_desc, remarks, modified_date, modified_by)
			VALUES($next_history_id, $header_id1, 5, 'Send To Oracle', 'Send To Oracle', '$date', '$create_by1');";
		$query = pg_query($conn, $ssql);

		if (!$query){
			 die("could not query the database: <br />".pg_errormessage());
		}
		else{
			pg_free_result($query);		
			echo "Upload Data to Oracle Success... ";
		}	
	} else {
		$sql = "DELETE FROM PO_REQUISITIONS_INTERFACE_ALL WHERE INTERFACE_SOURCE_CODE=:no_mr";  //EXECUTE PROCEDURE	             
		$s = oci_parse($connOra,$sql); 
		oci_bind_by_name($s, ":no_mr", $no_mr, 25);
		$r = oci_execute($s);
		if (!$r) 
		{	
			echo "Rollback Data Oracle Error... NoMR: " . $no_mr;
		} else {
			echo "Upload Data NoMR: " . $no_mr . " to Oracle Error...! ";
		}		
	}
	oci_free_statement($s);
	oci_close($connOra);	
	pg_close($conn);	

?>
