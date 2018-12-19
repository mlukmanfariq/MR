<?php
	//$connOra = oci_connect('APPS', 'APPS', '192.7.1.232:1521/PROD');
	$connOra = oci_connect('APPS', 'APPS', '192.6.1.221:1521/PROD');
	$description1 = trim(strtoupper($_REQUEST["description1"]));
	If (!$connOra) 
	{
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		echo $e;
	}	
	else 
	{	
		echo '
			<div class="clearfix">
				<div class="pull-right tableTools-container"></div>
			</div>
			<div class="table-header">
				View Tabel Material 
			</div>
			<div class="box-body table-responsive">
				<table id="dynamic-table" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>NO</th>
							<th>ITEM CODE</th>
							<th>UOM</th>
							<th>DESCRIPTION OF MATERIAL</th>
							<th>CATEGORY ID</th>
							<th>ORGANIZATION ID</th>
							<th>DESTINATION TYPE</th>
							<th>MIN QUANTITY</th>
							<th>MAX QUANTITY</th>
							<th>STOCK BAL</th>
							<th class="nosort"><center>ACTION</th>
						</tr>
					</thead>			
					<tbody>';
						$no = 1;
						$sqlOra="SELECT a.SEGMENT1, a.PRIMARY_UNIT_OF_MEASURE, a.DESCRIPTION, b.CATEGORY_ID, 
						a.ORGANIZATION_ID, DECODE(a.INVENTORY_ITEM_FLAG,'Y','INVENTORY','N','EXPENSE') AS DESTINATION_TYPE_CODE, 
						nvl(MIN_MINMAX_QUANTITY,0) as MIN_MINMAX_QUANTITY, nvl(MAX_MINMAX_QUANTITY,0) as MAX_MINMAX_QUANTITY, nvl(c.CUR_QTY,0) as CUR_QTY
						FROM MTL_SYSTEM_ITEMS_B a, MTL_ITEM_CATEGORIES b, PSP_MR_INV_CURRENT_QTY c 
						WHERE a.inventory_item_id = b.inventory_item_id and 
						a.inventory_item_id = c.inventory_item_id(+) and 
						a.ORGANIZATION_ID = b.ORGANIZATION_ID and a.ORGANIZATION_ID IN (43,44,45) 
						AND upper(a.SEGMENT1) = '".$description1."' AND ROWNUM <= 10 ORDER BY a.SEGMENT1";					
						$stid = oci_parse($connOra,$sqlOra ); 
						$filterOra = "%" . $description1 . "%";
						oci_bind_by_name($stid, ':filter', $description1);
						oci_execute($stid);													
						while ($row=oci_fetch_assoc($stid))
						{
						echo'
						<tr>
							<td><center><span class="badge badge-info">'.$no.'</span></td>
							<td>'.$row["SEGMENT1"].'</td>
							<td>'.$row["PRIMARY_UNIT_OF_MEASURE"].'</td>
							<td>'.$row["DESCRIPTION"].'</td>
							<td>'.$row["CATEGORY_ID"].'</td>
							<td>'.$row["ORGANIZATION_ID"].'</td>
							<td>'.$row["DESTINATION_TYPE_CODE"].'</td>							
							<td>'.$row["MIN_MINMAX_QUANTITY"].'</td>
							<td>'.$row["MAX_MINMAX_QUANTITY"].'</td>
							<td>'.$row["CUR_QTY"].'</td>
							<td><center><button id="selectItem" class="btn btn-success btn-minier" onclick="selectItem()"><i class="fa fa-check "></i></button></td>
						</tr>';	
						$no++;							
						}
					echo'</tbody>
				</table>
			</div>';	
	}
	oci_free_statement($stid);
	oci_close($connOra);
?>	