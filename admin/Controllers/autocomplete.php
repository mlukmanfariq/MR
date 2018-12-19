<?php
	$description1 = $_GET['description'];
	$connOra = oci_connect('APPS', 'APPS', '192.6.1.221:1521/PROD');
	If (!$connOra) 
	{
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		echo $e;
	}	
	else 
	{											
		$sqlOra="SELECT SEGMENT1, DESCRIPTION, PRIMARY_UOM_CODE FROM mtl_system_items_b Where description like '%".$description1."%' AND organization_id <> 41 ORDER BY SEGMENT1";					
		$stid = oci_parse($connOra,$sqlOra ); 													
		oci_execute($stid);
		// $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
		// $uom_code = $row['PRIMARY_UOM_CODE'];
		// $SEGMENT1 = $row['SEGMENT1'];														
		while ($row=oci_fetch_row($stid))
		{
			$data[] = $row['SEGMENT1'] . '--' . $row['DESCRIPTION'] . '--' . $row['PRIMARY_UOM_CODE'];
		}

	}
	
	echo json_encode($data);
	
?>