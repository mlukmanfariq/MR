<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$dept_id = $_REQUEST["deptid"];
	
	echo '
	<div class="clearfix">
		<div class="pull-right tableTools-container"></div>
	</div>
	<div class="table-header">
		View Tabel Requestor
	</div>
	<div class="box-body table-responsive">
		<table id="dynamic-tableRequestor" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>NO</th>
					<th>REQUESTOR ID</th>
					<th>NIK</th>
					<th>EMPLOYEE NAME</th>
				</tr>
			</thead>			
			<tbody>';
				$no = 1;
				$query = pg_query($conn, "SELECT * FROM tbl_r_employee where id_code = $dept_id");
				while ($result = pg_fetch_array($query)){ echo'
				<tr>
					<td><center><span class="badge badge-info">'.$no.'</span></td>
					<td>'.$result['id_code'].'</td>
					<td>'.$result['nik'].'</td>
					<td>'.$result['name'].'</td>
				</tr>';
				$no++;
				}echo'
			</tbody>
		</table>
	</div>';

	
?>

