<?php 
	
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$connOra = oci_connect('APPS', 'APPS', '192.7.1.232:1521/PROD');
	
	$header_id1=$_POST['header_id'];
	$create_by1=$_POST['create_by'];
	$date = date('Y-m-d H:i:s');
	
	If (!$connOra) 
	{
		$e_connect = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		echo $e;
	}	
	else 
	{		
		$sqlOra="select PO_REQUISITION_HEADERS_S.nextval as NEXTROW from dual";					
		$stid = oci_parse($connOra,$sqlOra); 
		oci_execute($stid);
		while ($row=oci_fetch_assoc($stid))
		{
			$requisition_header_id1 = $row['NEXTROW'];							
		}
	
		//echo $requisition_header_id1;
		oci_free_statement($stid);

		$ssql = "SELECT authorization_status, batch_id, category_id, charge_account_id, created_by, creation_date, currency_code, deliver_to_requestor_id, 
		destination_organization_id, destination_type_code, header_description, interface_source_code, trim(item_description) as item_description, trim(item_segment1) as item_segment1, preparer_id, 
		quantity, req_number_segment1, requisition_header_id, requisition_type, source_type_code, unit_of_measure, unit_price, line_attribute9, 
		need_by_date, deliver_to_location_id, oracle_flag 
		FROM requisition_interface_all where batch_id = $header_id1"; 
		$query = pg_query($conn, $ssql);

		while ($result = pg_fetch_array($query)){		

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
			$interface_source_code1=trim($result['interface_source_code']);
			$item_description1=trim($result['item_description']);
			$item_segment11=trim($result['item_segment1']);
			$preparer_id1=trim($result['preparer_id']);
			$quantity1=trim($result['quantity']);
			$req_number_segment11=trim($result['req_number_segment1']);
			$requisition_type1=trim($result['requisition_type']);
			$source_type_code1=trim($result['source_type_code']);
			$unit_of_measure1=trim($result['unit_of_measure']);
			$unit_price1=trim($result['unit_price']);
			$line_attribute91=trim($result['line_attribute9']);
			$need_by_date1=date("m/d/Y", strtotime(trim($result['need_by_date'])));
			$deliver_to_location_id1=trim($result['deliver_to_location_id']);
			

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
				:need_by_date
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
				oci_bind_by_name($stid, ":header_description", $header_description1, 25);
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
				$r = oci_execute($stid);

				if (!$r) 
				{	
					$e = oci_error($stid);
					trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);	
				}		
			}
		}		
	}
	oci_free_statement($stid);
	oci_close($connOra);
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
	pg_close($conn);

		
?>
