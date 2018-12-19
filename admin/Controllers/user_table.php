<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$name = strtoupper($_REQUEST["user"]);
	$option = $_REQUEST["option"];
	
	$cek = pg_query($conn, "SELECT * FROM tbl_r_employee where upper(name) like '%$name%'");
	$cek_row = pg_num_rows($cek);
	echo '
	<div class="clearfix">
		<div class="pull-right tableTools-container"></div>
	</div>
	<div class="table-header">
		View Tabel Employee
	</div>
	<div class="box-body table-responsive">
		<table id="dynamic-tableRequestor" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>NO</th>
					<th>REQUESTOR ID</th>
					<th>NIK</th>
					<th>NAME</th>
					<th>DEPT</th>
					<th>SECTION</th>
					<th class="nosort"><center>ACTION</th>
				</tr>
			</thead>			
			<tbody>';
				$no = 1;
				$query = pg_query($conn, "SELECT * FROM tbl_r_employee where upper(name) like '%$name%' ORDER BY NAME limit 10");
				while ($result = pg_fetch_array($query)){ echo'
				<tr>
					<td><center><span class="badge badge-info">'.$no.'</span></td>
					<td>'.$result['id_code'].'</td>
					<td>'.$result['nik'].'</td>
					<td>'.$result['name'].'</td>
					<td>'.$result['departemen'].'</td>
					<td>'.$result['section'].'</td>
					<td>';
						if ($option == 'user') {
							echo '<center><button id="selectRequestor" class="btn btn-success btn-minier" onclick="selectRequestor()"><i class="fa fa-check "></i></button>';
						} else {
							echo '<center><button id="selectRequestor" class="btn btn-success btn-minier" onclick="selectApproval()"><i class="fa fa-check "></i></button>';
						}
						
					
					echo '</td>
				</tr>';
				$no++;
				}echo'
			</tbody>
		</table>
	</div>';

	
?>

